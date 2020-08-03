<?php
	namespace hybridmind\interval_time\event;
	
	use Symfony\Component\EventDispatcher\EventSubscriberInterface;
	
	
	
	class listener implements EventSubscriberInterface
	{
		
		/** @var \phpbb\config\config */
		protected $config;
		
		/** @var \phpbb\template\template */
		protected $template;
		
		/** @var \phpbb\user */
		protected $user;
		
		protected $db;
		
		
		public function __construct( \phpbb\config\config $config, \phpbb\template\template $template,  \phpbb\user $user,\phpbb\db\driver\driver_interface $db)
		{
			$this->config = $config;
			$this->template = $template;
			$this->user = $user;
			$this->db = $db;
			
		}
		
		
		
		static public function getSubscribedEvents()
		{
			return array(
			'core.page_footer'=>'check_ids',
			);
		}
		
		
		
		public function check_ids($event) {
			global $user;
			$this->template->assign_vars(array(
			'USER_ID'			=> $user->data['user_id'],
			));
			
		}
		
	}	