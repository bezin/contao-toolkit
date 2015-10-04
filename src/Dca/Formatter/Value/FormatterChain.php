<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\Toolkit\Dca\Formatter\Value;

use Netzmacht\Contao\Toolkit\Dca\Definition;

/**
 * Set of multiple formatters.
 *
 * @package Netzmacht\Contao\Toolkit\Dca\Formatter\Value
 */
class FormatterChain implements ValueFormatter
{
    /**
     * @var ValueFormatter[]
     */
    private $formatters = array();

    /**
     * FormatterChain constructor.
     *
     * @param ValueFormatter[] $formatters Value formatters.
     */
    public function __construct(array $formatters)
    {
        $this->formatters = $formatters;
    }

    /**
     * {@inheritDoc}
     */
    public function accept($fieldName, array $fieldDefinition, Definition $definition)
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->accept($fieldName, $fieldDefinition, $definition)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function format($value, $fieldName, array $fieldDefinition, Definition $definition, $context = null)
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->accept($fieldName, $fieldDefinition, $definition)) {
                $formatter->format($value, $fieldName, $fieldDefinition, $definition, $context);
            }
        }

        return null;
    }
}