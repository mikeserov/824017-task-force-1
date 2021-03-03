<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

abstract class AbstractAction {
	protected string $internalActionName;
	protected string $displayingActionName;
	abstract public function getInternalActionName();
	abstract public function getDisplayingActionName();
	abstract public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole);
}