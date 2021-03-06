<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

class ExecuteAction extends AbstractAction {
	
	public function __construct()
	{
		$this->internalName = Task::TO_EXECUTE;
		$this->displayingName = 'Откликнуться';
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
		return $currentUserRole === 'executant' && $currentUserId !== $customerId ? true : false;
	}
}