<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 * @see https://core.telegram.org/bots#keyboards custom keyboard
 * @see https://core.telegram.org/bots#keyboards Introduction to bots
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup extends BaseType implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of KeyboardButton objects
     * @var \SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton[][] $keyboard
     */
    #[ArrayType(KeyboardButton::class, depth: 2)]
    public array $keyboard;

    /**
     * Optional. Requests clients to resize the keyboard vertically for optimal fit
     * (e.g., make the keyboard smaller if there are just two rows of buttons).
     * Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
     */
    public ?bool $resize_keyboard = null;

    /**
     * Optional. Requests clients to hide the keyboard as soon as it's been used.
     * The keyboard will still be available, but clients will automatically display the usual
     * letter-keyboard in the chat – the user can press a special button in the input field to
     * see the custom keyboard again.
     * Defaults to false.
     */
    public ?bool $one_time_keyboard = null;

    /**
     * Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
     */
    public ?string $input_field_placeholder = null;

    /**
     * Optional. Use this parameter if you want to show the keyboard to specific users only.
     * Targets:
     * 1) users that are [at]mentioned in the text of the Message object;
     * 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     * Example: A user requests to change the bot‘s language,
     * bot replies to the request with a keyboard to select the new language.
     * Other users in the group don’t see the keyboard.
     * @ee https://core.telegram.org/bots/api#message Message
     */
    public ?bool $selective = null;

    public function __construct(
        ?bool $resize_keyboard = null,
        ?bool $one_time_keyboard = null,
        ?string $input_field_placeholder = null,
        ?bool $selective = null,
    ) {
        parent::__construct();
        $this->resize_keyboard = $resize_keyboard;
        $this->one_time_keyboard = $one_time_keyboard;
        $this->input_field_placeholder = $input_field_placeholder;
        $this->selective = $selective;
    }

    public static function make(
        ?bool $resize_keyboard = null,
        ?bool $one_time_keyboard = null,
        ?string $input_field_placeholder = null,
        ?bool $selective = null,
    ): self {
        return new self(
            $resize_keyboard,
            $one_time_keyboard,
            $input_field_placeholder,
            $selective,
        );
    }

    /**
     * @param  KeyboardButton  ...$buttons
     * @return $this
     */
    public function addRow(...$buttons): static
    {
        $this->keyboard[] = $buttons;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'keyboard' => $this->keyboard ?? [],
            'resize_keyboard' => $this->resize_keyboard,
            'one_time_keyboard' => $this->one_time_keyboard,
            'input_field_placeholder' => $this->input_field_placeholder,
            'selective' => $this->selective,
        ]);
    }
}
