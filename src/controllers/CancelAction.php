<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class CancelAction extends AbstractAction {
	
	public function __construct()
	{
		$this->internalName = Task::TO_CANCEL;
		$this->displayingName = 'Отменить';
	}

	public function getInternalName()
	{
		return $this->internalActionName;
	}
	public function getDisplayingName()
	{
		return $this->displayingActionName;
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole): bool
	{
		return $currentUserId === $customerId ? true : false;
	}
}