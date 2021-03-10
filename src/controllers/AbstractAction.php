<?php

declare(strict_types = 1);

namespace TaskForce\Controllers;

abstract class AbstractAction
{
	protected string $internalName;
	protected string $displayingName;

	abstract public function getInternalName();
	abstract public function getDisplayingName();
	abstract public function canUserAct(int $customerId, int $executantId, int $currentUserId, ?string $currentUserRole);
}