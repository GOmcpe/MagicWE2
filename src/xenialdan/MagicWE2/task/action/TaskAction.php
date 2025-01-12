<?php

declare(strict_types=1);

namespace xenialdan\MagicWE2\task\action;

use Generator;
use pocketmine\math\Vector3;
use xenialdan\MagicWE2\clipboard\SingleClipboard;
use xenialdan\MagicWE2\helper\AsyncChunkManager;
use xenialdan\MagicWE2\helper\BlockPalette;
use xenialdan\MagicWE2\selection\Selection;

abstract class TaskAction
{
	/** @var string */
	public string $prefix = "";
	/** @var bool */
	public bool $addRevert = true;
	/** @var string */
	public string $completionString = '{%name} succeed, took {%took}, {%changed} blocks out of {%total} changed.';
	/** @var bool */
	public bool $addClipboard = false;
	/** @var null|Vector3 */
	public ?Vector3 $clipboardVector = null;
	//TODO add $flags and define available flags in child classes
	//public $flags
	//protected const AVAILABLE_FLAGS = [];(can be overwritten), access with static::AVAILABLE_FLAGS

	/**
	 * @param string $sessionUUID
	 * @param Selection $selection
	 * @param AsyncChunkManager $manager
	 * @param null|int $changed
	 * @param BlockPalette $newBlocks
	 * @param BlockPalette $blockFilter
	 * @param SingleClipboard $oldBlocksSingleClipboard blocks before the change
	 * @param string[] $messages
	 * @return Generator
	 */
	abstract public function execute(string $sessionUUID, Selection $selection, AsyncChunkManager $manager, ?int &$changed, BlockPalette $newBlocks, BlockPalette $blockFilter, SingleClipboard $oldBlocksSingleClipboard, array &$messages = []): Generator;

	abstract public static function getName(): string;

	/**
	 * @param Vector3|null $clipboardVector
	 */
	public function setClipboardVector(?Vector3 $clipboardVector): void
	{
		if ($clipboardVector instanceof Vector3) $clipboardVector = $clipboardVector->asVector3()->floor();
		$this->clipboardVector = $clipboardVector;
	}
}