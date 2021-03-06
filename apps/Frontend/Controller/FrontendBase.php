<?php
namespace Frontend\Controller;
use Flywheel\Config\ConfigHandler;
use Toxotes\Controller;
use Toxotes\Plugin;

abstract class FrontendBase extends Controller {
    public function beforeExecute()
    {
        parent::beforeExecute(); // TODO: Change the autogenerated stub
        $document = $this->document();
        $document->title = '';
        $this->_initTemplate();
        $this->_initLanguages();

        Plugin::addFilter('custom_router_param', function($route, $params) {
            if ('products/category' == $route) {
                if (isset($params['id']) && ($term = \Terms::retrieveById($params['id']))) {
                    $params['slug'] = $term->getSlug();
                }
            }
            if ('products/detail' == $route) {
                if (isset($params['id']) && ($item = \Items::retrieveById($params['id']))) {
                    $params['slug'] = $item->getSlug();
                }
            }

            return $params;
        }, 1, 2);
    }

    private function _initTemplate()
    {
        $template = ConfigHandler::get('template');
        include_once $this->getTemplatePath().DIRECTORY_SEPARATOR.'template_init.php';
    }

    public function raise404($mess = null) {
        echo '<meta charset="UTF-8">';
        die($mess);
//        $this->redirect($controller->createUrl("error"));
    }

}
