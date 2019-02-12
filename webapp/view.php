<?php

class View
{
	function generate($content_view, $template_view, $data = null)
	{
		include 'webapp/views/'.$template_view;
	}
}
