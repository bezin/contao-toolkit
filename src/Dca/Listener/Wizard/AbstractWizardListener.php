<?php

/**
 * Contao toolkit.
 *
 * @package    contao-toolkit
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus.
 * @license    LGPL-3.0 https://github.com/netzmacht/contao-toolkit/blob/master/LICENSE
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\Toolkit\Dca\Listener\Wizard;

use Contao\DataContainer;
use Netzmacht\Contao\Toolkit\Dca\Definition;
use Netzmacht\Contao\Toolkit\Dca\Manager;
use Symfony\Component\Templating\EngineInterface as TemplateEngine;
use Symfony\Component\Translation\TranslatorInterface as Translator;

/**
 * AbstractWizard is the base class for a wizard.
 *
 * @package Netzmacht\Contao\Toolkit\View\Wizard
 */
abstract class AbstractWizardListener
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $template;

    /**
     * Translator.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Template factory.
     *
     * @var TemplateEngine
     */
    private $templateEngine;

    /**
     * Data container manager.
     *
     * @var Manager
     */
    protected $dcaManager;

    /**
     * PagePickerCallback constructor.
     *
     * @param TemplateEngine $templateEngine Template engine.
     * @param Translator     $translator     Translator.
     * @param Manager        $dcaManager     Data container manager.
     * @param string|null    $template       Template name.
     */
    public function __construct(
        TemplateEngine $templateEngine,
        Translator $translator,
        Manager $dcaManager,
        ?string $template = null
    ) {
        $this->translator     = $translator;
        $this->templateEngine = $templateEngine;
        $this->dcaManager     = $dcaManager;

        if ($template) {
            $this->template = $template;
        }
    }

    /**
     * Render a template.
     *
     * @param string|null $name       Custom template name. If null main wizard template is used.
     * @param array       $parameters Parameters.
     *
     * @return string
     */
    protected function render(?string $name = null, array $parameters = []): string
    {
        return $this->templateEngine->render($name ?: $this->template, $parameters);
    }

    /**
     * Get the data container definition.
     *
     * @param DataContainer $dataContainer Data container driver.
     *
     * @return Definition
     */
    protected function getDefinition($dataContainer): Definition
    {
        return $this->dcaManager->getDefinition($dataContainer->table);
    }

    /**
     * Invoke by the callback.
     *
     * @param DataContainer $dataContainer Data container driver.
     *
     * @return string
     */
    abstract public function handleWizardCallback($dataContainer): string;
}
