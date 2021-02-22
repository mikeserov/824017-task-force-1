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
		'failed' => 'Провалено',
		'to cancel' => 'Отменить',
		'to execute' => 'Откликнуться',
		'to accomplish' => 'Выполнено',
		'to fail' => 'Отказаться'
	];
	private array $status_changes = [
		'new' => [
			'to cancel' => 'canceled',
			'to execute' => 'executing'
		],
		'executing' => [
			'to accomplish' => 'accomplished',
			'to fail' => 'failed'
		]
	];

	public function __construct(int $executant_id, int $customer_id) //нужно ли указывать 2-й параметр необязательным, т.е. ?int $customer_id=null
	{
		$this->executant_id = $executant_id;
		$this->customer_id = $customer_id;
		$this->cur_status = self::STATUS_NEW;
	}

	public function getStatusCausedByAction(string $action): ?string 
	{	
		if ($is_able_to_change_cur_status = array_key_exists($this->cur_status, $this->status_changes)) {
			if (isset($this->status_changes[$this->cur_status][$action])) {
				return $this->status_changes[$this->cur_status][$action];
			}
		}
		return null;
	}
	public function getAvailableAction(int $user_id): ?string 
	{
		switch ($this->cur_status) {
			case 'new': 
				if ($user_id === $this->executant_id) {
					$available_action = 'to execute'; 			 //нужно ли поставить в case константу вместо 'new', т.е. self::STATUS_NEW.
				} else {
					$available_action = 'to cancel';
				} 
				break;
			case 'executing':
				if ($user_id === $this->executant_id) {
					$available_action = 'to fail';  			
				} else {
					$available_action = 'to accomplish';
				}
				break;
			default:
				$available_actions = null; 
		}
		return $available_action;  //проходит ли это по критерию Б36?
	}
	public function getMapping(): array
	{
		return $this->mapping;
	}

	//метод добавлен с целью проверки других методов класса Task в test.php
	//по завершению задания этот метод будет удален
	public function setStatus(string $new_status)
	{
		$this->cur_status = $new_status;
	} 

}