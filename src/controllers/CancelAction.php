<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class CancelAction extends AbstractAction {
	
	private string $InternalActionName;
	private string $DisplayingActionName;

	public function __construct()
	{
		$this->$InternalActionName = Task::TO_CANCEL;
		$this->$DisplayingActionName
	}

	public function getInternalActionName()
	{
		return Task::TO_CANCEL;
	}
	public function getDisplayingActionName()
	{
		return Task::getMappingElementValue(Task::TO_CANCEL);
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, string $currentUserRole): bool
	{
		return $currentUserRole === 'executant' && $currentUserId !== $customerId ? true : false;
	}
}