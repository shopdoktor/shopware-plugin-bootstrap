<?php
/**
 * Copyright Sebastian Lenz
 * website: https://www.shopdoktor.com/
*/
class Shopware_Plugins_Frontend_LenzPluginCode_Bootstrap extends Shopware_Components_Plugin_Bootstrap {
	/**
	 * @return array
	 */
	public function getCapabilities() {
		return array(
			'install' => true,
			'update' => true,
			'enable' => true
		);
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function getLabel() {
		$info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'plugin.json'), true);
		if ($info) {
			return $info['label']['de'];
		} else {
			throw new Exception('The plugin has an invalid label file.');
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function getVersion() {
		$info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'plugin.json'), true);
		if ($info) {
			return $info['currentVersion'];
		} else {
			throw new Exception('The plugin has an invalid version file.');
		}
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function getInfo() {
		$info = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'plugin.json'), true);
		if ($info) {
			return array(
				'version' => $info['currentVersion'],
				'copyright' => $info['copyright'],// Copyright-Hinweis
				'label' => $info['label']['de'],
				'description' => $info['description']['de'],// Info-Text, der in den Plugin-Details angezeigt wird
				'link' => $info['link'],
				'author' => $info['author'],
				'revision' => $info['currentRevision']// Aktuelle Revision des Plugins
			);
		} else {
			throw new Exception('The plugin has an invalid version file.');
		}
	}

	/**
	 * @return array
	 */
	public function install() {
		// Events
		$this->registerEvents();

		// Form
		$this->createForm();

		return true;
	}

	public function update() {
		return true;
	}

	public function uninstall() {
		return true;
	}

	private function createForm() {
		// Create a form.
		$form = $this->Form();

		// Add a text value field.
		$form->setElement('text', 'configKey',
			array(
				'label' => 'A Config Key',
				'value' => NULL,
				'description' => 'Enter your config key here.',
			)
		);
	}

	private function registerEvents() {
		// A Dispatch Event
		/*$this->subscribeEvent(
			'Enlight_Controller_Action_PostDispatch_Frontend_Checkout',
			'onPostDispatchCheckout'
		);*/

		// An old core event.
		/*$this->subscribeEvent(
			'sOrder::sSaveOrder::after',
			'afterSaveOrder'
		);*/
	}

	/**
	 * @param Enlight_Event_EventArgs $args
	 */
	public function onPostDispatchCheckout(Enlight_Event_EventArgs $args) {
		$subject  = $args->getSubject();
		$request  = $subject->Request();
		$response = $subject->Response();
		$action   = $request->getActionName();
		/** @var $view */
		$view     = $subject->View();

		if(!$request->isDispatched()
		   || $response->isException()
		   || $request->getModuleName() != 'frontend'
		   || $request->getControllerName() != 'checkout'
		   || !$args->getSubject()->View()->hasTemplate()
		) {
			return;
		}

		// Start your code here.
	}

	/**
	 * @param Enlight_Hook_HookArgs $args
	 */
	public function afterSaveOrder(Enlight_Hook_HookArgs $args) {
		//$orderNumber = $args->getReturn();
	}
}