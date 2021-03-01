<?php

declare(strict_types = 1);

namespace TaskForce\controllers;

abstract class AbstractAction {
	abstract public function getInternalActionName();
	abstract public function getDisplayingActionName();
	abstract public function canUserAct();
}