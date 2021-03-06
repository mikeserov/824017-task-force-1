<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class FailAction extends AbstractAction {
	
	public function __construct()
	{
		$this->internalName = Task::TO_FAIL;
		$this->displayingName = 'Отказаться';
	}

	public function getInternalName()
	{
		return $this->internalName;
	}
	public function getDisplayingName()
	{
		return $this->displayingName;
	}
	public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole): bool
	{
		return $currentUserId === $executantId ? true : false;
	}
}