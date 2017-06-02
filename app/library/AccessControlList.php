<?php
namespace Library;

use \Phalcon\Acl;
use \Phalcon\Acl\Role;
use \Phalcon\Acl\Resource;
use \Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Acl\Adapter\Memory as AclList;

/**
 * Class AccessControlList
 */
Class AccessControlList extends \Phalcon\Mvc\User\Component
{
    private $aclList;

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $role = 'Guest';
        if ($this->auth->isSignedIn()) {
            $role = $this->auth->get()->is_admin ? 'Admin' : 'User';
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        if (!$this->getAcl()->isAllowed($role, $controller, $action)) {
            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'forbidden',
            ]);
        }
    }

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl()
    {
        $cacheKey = '_aclList';
        if (!$this->cache->get($cacheKey)) {
            $this->aclList = new AclList();
            $this->aclList->setDefaultAction(Acl::DENY);

            // Register roles
            foreach ($this->config->acl->roles as $role => $description) {
                $this->aclList->addRole(new Role($role, $description));
            }

            $configuredResources = $this->config->acl->resources->toArray();

            foreach ($configuredResources as $name => $resources) {
                // Register resources
                foreach ($resources as $resource => $actions) {
                    $this->aclList->addResource(new Resource($resource), $actions);
                }
                
                $this->setAccess($resources, $this->config->acl->access->{$name}->toArray());
            }
            
            $this->cache->save($cacheKey, $this->aclList);
        }

        return $this->cache->get($cacheKey);
    }

    /**
     * Sets access to a list of resources for the given roles
     *
     * @param array $resources
     * @param array $roles
     */
    private function setAccess(array $resources, array $roles) : void
    {
        foreach ($roles as $role) {
            foreach ($resources as $resource => $actions) {
                foreach ($actions as $action) {
                    $this->aclList->allow($role, $resource, $action);
                }
            }
        }
    }
}