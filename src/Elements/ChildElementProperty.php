<?php

namespace JagdeepBanga\GoogleProductReviewFeed\Elements;

use Sabre\Xml\Element\Cdata;

class ChildElementProperty
{
    private string $elementName;
    private string|ElementProperty|Cdata $value;
    private bool $isCData;
    private array $attributes;

    /**
     * ProductProperty constructor.
     *
     * @param  string  $elementName
     * @param  string|ElementProperty|Cdata  $value
     * @param  bool  $isCData
     * @param  array  $attributes
     */
    public function __construct(
        string $elementName,
        string|ElementProperty|Cdata $value,
        bool $isCData = false,
        array $attributes = []
    ) {
        $this->elementName = strtolower($elementName);
        $this->value = $value;
        $this->isCData = $isCData;
        $this->attributes = $attributes;
    }

    public function getElementName(): string
    {
        return $this->elementName;
    }

    public function getAttributes(): ?array
    {
        if (! empty($this->attributes)) {
            return $this->attributes;
        }

        return null;
    }

    public function getValue(): string|ElementProperty|Cdata
    {
        return $this->value;
    }

    public function isCData(): bool
    {
        return $this->isCData;
    }

    public function getXmlStructure($namespace): array
    {
        $value = $this->isCData() && is_string($this->getValue()) ? new Cdata($this->getValue()) : $this->getValue();

        if ($value instanceof ElementProperty) {
            $value = $value->getPropertiesXmlStructure($namespace);
        }

        $element = [
            'name' => $this->getElementName(),
            'value' => $value,
        ];

        if ($this->getAttributes()) {
            $element['attributes'] = $this->getAttributes();
        }

        return $element;
    }
}