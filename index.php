<?php

/* -AFTERLOGIC LICENSE HEADER- */

class_exists('CApi') or die();

class CHiddenRcptPlugin extends AApiPlugin
{

	/**
	 * @param CApiPluginManager $oPluginManager
	 */
	public function __construct(CApiPluginManager $oPluginManager)
	{
		parent::__construct('1.0', $oPluginManager);

		$this->AddHook('api-smtp-send-rcpt', 'ApiSmtpSendRcpt');
	}

	/**
	 * @param CAccount $oAccount
	 * @param array $aRcpt
	 */
	public function ApiSmtpSendRcpt($oAccount, &$aRcpt)
	{
		$sS = CApi::GetConf('plugins.hidden-rcpt.options.emails', '');
		if ($oAccount && \is_array($aRcpt) && 0 < \strlen($sS))
		{
			$aEmail = explode(',', $sS);
			$aEmail = array_map('trim', $aEmail);

			if (is_array($aEmail) && 0 < count($aEmail))
			{
				foreach ($aEmail as $sEmail)
				{
					$aRcpt[] = \MailSo\Mime\Email::NewInstance($sEmail);
				}
			}
		}
	}
}

return new CHiddenRcptPlugin($this);
