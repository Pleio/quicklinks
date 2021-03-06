<?php
/**
 * Save/edit a quicklink items
 *
 * @todo support edit
 * @todo sticky form
 */

$title = get_input("title");
$url = get_input("url");
$container_guid = (int) get_input("container_guid");

if (!empty($url)) {
	$entity = new ElggObject();
	$entity->subtype = QUICKLINKS_SUBTYPE;
	$entity->owner_guid = elgg_get_logged_in_user_guid();
	$entity->container_guid = $container_guid;
	$entity->access_id = ACCESS_PRIVATE;
	
	$entity->title = $title;
	$entity->description = $url;
	
	if ($entity->save()) {
		add_entity_relationship(elgg_get_logged_in_user_guid(), QUICKLINKS_RELATIONSHIP, $entity->getGUID());
		
		system_message(elgg_echo("save:success"));
	} else {
		register_error(elgg_echo("save:fail"));
	}
} else {
	register_error(elgg_echo("error:missing_data"));
}

forward(REFERER);