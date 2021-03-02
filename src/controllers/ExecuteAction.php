<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class ExecuteAction extends AbstractAction {
	
	public function getInternalActionName()
	{
		return 'Откликнуться';
	}
	public function getDisplayingActionName()
	{
		return 'to execute';
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, string $currentUserRole): bool
	{
		return $currentUserRole === 'executant' && $currentUserId !== $customerId ? true : false;
	}
}