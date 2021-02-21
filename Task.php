<?php
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

	private string $cur_status;
	private int $customer_id;
	private int $executant_id;
	
	private array $mapping = [
		'new' => 'Новое',
		'canceled' => 'Отменено',
		'executing' => 'В работе',
		'accomplished' => 'Выполнено',
		'failed' => 'Провалено'
		'to cancel' => 'Отменить',
		'to execute' => 'Откликнуться',
		'to accomplish' => 'Выполнено',
		'to fail' => 'Отказаться'
	];
	private array $status_changes = [
		'new' => [
			'to cancel' => 'canceled',
			'to execute' => 'executed'
		],
		'executing' => [
			'to accomplish' => 'accomplished',
			'to fail' => 'failed'
		]
	];

	public __construct(int $executant_id, int $customer_id) //нужно ли указывать 2-й параметр необязательным, т.е. ?int $customer_id=null
	{
		$this->executant_id = $executant_id;
		$this->customer_id = $customer_id;
		$this->cur_status = self::STATUS_NEW;

	}

	public function getStatusCausedByAction(string $action): ?string 
	{
		if ($is_able_to_change_cur_status = array_key_exists($this->cur_status, $this->status_changes)) {
			if (isset($status_changes[$this->cur_status][$action])) {
				return $status_changes[$this->cur_status][$action];
			}
		}
		return null;
	}
	public function getAvailableActions(int $user_id): 
	{
		switch ($this->cur_status) {
			case 'new': 												//нужно ли поставить в case константу вместо строки, т.е. self::STATUS_NEW.
				$available_actions = ['to_cancel', 'to execute'];
				break;
			case 'executing': 											
				$available_actions = ['to accomplish', 'to fail'];
				break;
			default:
				$available_actions = null; 
		}
		if ($user_id === $executor)

		return $available_actions;
	}
	public function getMapping()
	{
		return $this->mapping;
	}
}