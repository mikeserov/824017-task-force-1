<?php
declare(strict_types = 1);
namespace TaskForce\controllers;

class Task
{
	const STATUS_NEW = 'new';
	const STATUS_CANCELED = 'canceled';
	const STATUS_EXECUTING = 'executing';
	const STATUS_ACCOMPLISHED = 'accomplished';
	const STATUS_FAILED = 'failed';
	const TO_CANCEL = 'to cancel';
	const TO_EXECUTE = 'to execute';
	const TO_ACCOMPLISH = 'to accomplish';
	const TO_FAIL = 'to fail';

	private string $currentStatus;
	private int $customerId;
	private int $executantId;
	
	private array $mapping = [
		self::STATUS_NEW => 'Новое',
		self::STATUS_CANCELED => 'Отменено',
		self::STATUS_EXECUTING => 'В работе',
		self::STATUS_ACCOMPLISHED => 'Выполнено',
		self::STATUS_FAILED => 'Провалено',
		self::TO_CANCEL => 'Отменить',
		self::TO_EXECUTE => 'Откликнуться',
		self::TO_ACCOMPLISH => 'Выполнено',
		self::TO_FAIL => 'Отказаться'
	];
	private array $statusChanges = [
		self::STATUS_NEW => [
			self::TO_CANCEL => self::STATUS_CANCELED,
			self::TO_EXECUTE => self::STATUS_EXECUTING
		],
		self::STATUS_EXECUTING => [
			self::TO_ACCOMPLISH => self::STATUS_ACCOMPLISHED,
			self::TO_FAIL => self::STATUS_FAILED
		]
	];

	public function __construct(int $executantId, int $customerId)
	{
		$this->executantId = $executantId;
		$this->customerId = $customerId;
		$this->currentStatus = self::STATUS_NEW;
	}

	public function getStatusCausedByAction(string $action): ?string 
	{	
		$isAbleToChangeCurrentStatus = isset($this->statusChanges[$this->currentStatus]);
		if ($isAbleToChangeCurrentStatus) {
			if (isset($this->statusChanges[$this->currentStatus][$action])) {
				return $this->statusChanges[$this->currentStatus][$action];
			}
		}
		return null;
	}
	public function getAvailableAction(int $userId, string $userRole): ?string 
	{
		switch ($this->currentStatus) {
			case self::STATUS_NEW:
				$availableAction = $userId === $this->executantId ? self::TO_EXECUTE : self::TO_CANCEL; 										
				break;
			case self::STATUS_EXECUTING:
				$availableAction = $userId === $this->executantId ? self::TO_FAIL : self::TO_ACCOMPLISH;
				break;
			default:
				$availableAction = null; 
		}
		return $availableAction;
	}
	public function getMappingElementValue(string $actionOrStatusName): ?string
	{
		if (isset($this->mapping[$actionOrStatusName])) {
			return $this->mapping[$actionOrStatusName];
		} 
		return null;
	}

	//метод для тестирования класса.
	//по завершению задания удалю его.
	public function setStatus(string $newStatus): string
	{
		$this->currentStatus = $newStatus;
		return "статус сменен на $this->currentStatus <br><br>";
	} 

}