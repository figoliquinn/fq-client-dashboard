<?php
	
class DashboardWidget {
	
	// The title and slug of the dashboard widget to create
	public $title;
	public $slug;
	public $content;
	
	// Set the slug and title based on the name passed in
	public function __construct($name)
	{
		$this->title = $name;
		$this->slug  = str_replace(' ', '_', $name); 
		$this->content = '';
	}
	
	// Fills the widget with static content
	public function setStaticContent($content)
	{
		$this->content = $content;
	}
	
	// Fills the widget with an RSS feed
	public function setRSSContent($feed)
	{
		$feedMax = 5;
		$channel = new stdClass();
		
		if (empty(wp_cache_get( $feed, null, $force = false, $found = null )))
		{
			// Fetch the XML
			$xml = simplexml_load_file($feed);
			$channel = $xml->channel;
			
			// cache this data
			wp_cache_add( $feed, $channel, null, 60 * 60 * 24 );
		}
		else
		{
			$channel = wp_cache_get( $feed, null, $force = false, $found = null );
		}
		
		// Render the output from the view file
		ob_start();
		include('templates/rss-feed.php');
		$template = ob_get_contents();
		ob_end_clean();	
		
		$this->content = $template;	
	}
	
	// Render it to the dashboard
	public function create()
	{
		// Register the widget
		add_action( 'wp_dashboard_setup', array($this, 'register'));
	}
	
	public function register()
	{
		wp_add_dashboard_widget(
			$this->slug,
			$this->title,
			array($this, 'render')
		);
	}
	
	public function render()
	{
		echo $this->content;
	}
	
}