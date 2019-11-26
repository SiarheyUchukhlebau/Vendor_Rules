<?php

namespace Vendor\Rules\Block\Cart;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Model\Quote\Address as QuoteAddress;
use Vendor\Rules\Model\Rule;
use Vendor\Rules\Model\ResourceModel\Rule\CollectionFactory as RulesCollectionFactory;

/**
 * Class RuleExample
 */
class RuleExample extends Template
{
    /**
     * @var RulesCollectionFactory
     */
    private $rulesCollectionFactory;

    /**
     * @var string
     */
    private $message;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * RuleExample constructor.
     *
     * @param Template\Context $context
     * @param RulesCollectionFactory $rulesCollectionFactory
     * @param CheckoutSession $checkoutSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        RulesCollectionFactory $rulesCollectionFactory,
        CheckoutSession $checkoutSession,
        array $data = []
    ) {
        $this->rulesCollectionFactory = $rulesCollectionFactory;
        $this->checkoutSession        = $checkoutSession;
        $this->message                = '';
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        if ($this->message) {
            return $this->message;
        }

        $shippingAddress = $this->getShippingAddress();
        if (!$shippingAddress) {
            return $this->message;
        }

        $rule = $this->getRule();
        if ($rule && $rule->validate($shippingAddress)) {
            $this->message = __(
                'You have some heavy weight items in your cart, please contact us to discuss delivery.'
            );
        }

        return $this->message;
    }

    /**
     * @return Rule|null
     */
    private function getRule(): ?Rule
    {
        /** @var \Vendor\Rules\Model\ResourceModel\Rule\Collection $rulesCollection */
        $rulesCollection = $this->rulesCollectionFactory->create();
        $rulesCollection->addFilter('rule_id', 1);
        /** @var Rule|null $rule */
        $rule = $rulesCollection->getFirstItem();

        return $rule;
    }

    /**
     * @return QuoteAddress|null
     */
    private function getShippingAddress(): ?QuoteAddress
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        try {
            $quote = $this->checkoutSession->getQuote();
        } catch (LocalizedException $exception) {
            return null;
        }

        if (!$quote) {
            return null;
        }

        return $quote->getIsVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
    }
}
