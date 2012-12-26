<?php
// XML-related routine
        $content = "<?xml version=\"1.0\"?>
<config>
	<red5Url>rtmp://178.63.54.212/sip</red5Url>
	<sipRealm>asterisk</sipRealm>
	<sipServer>89.169.45.200</sipServer>
	<obProxy>89.169.45.200</obProxy>
        <phone>1</phone>
        <userName>click2call-office</userName>
        <password>1</password>
        <phoneDial>111111</phoneDial>
</config>";

        // Both layout and view renderer should be disabled
        Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->setNoRender(true);
        //Zend_Layout::getMvcInstance()->disableLayout();

        // Set up headers and body
        $this->_response->setHeader('Content-Type', 'text/xml; charset=utf-8')
            ->setBody($content);

