<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class AccomplishAction extends AbstractAction {
	
	public function getInternalActionName()
	{
		
	}
	public function getDisplayingActionName()
	{
		return 'to accomplish';
	}
	public function canUserAct(int executantId, int customerId, int currentUserId): bool
	{
		return customerId === currentUserId ? true : false;
	}
}