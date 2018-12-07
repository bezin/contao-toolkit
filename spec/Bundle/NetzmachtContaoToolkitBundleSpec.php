<?php

declare(strict_types=1);

namespace spec\Netzmacht\Contao\Toolkit\Bundle;

use Netzmacht\Contao\Toolkit\Bundle\DependencyInjection\Compiler\FosCacheResponseTaggerPass;
use Netzmacht\Contao\Toolkit\Bundle\DependencyInjection\Compiler\RegisterHooksPass;
use Netzmacht\Contao\Toolkit\Bundle\DependencyInjection\Compiler\RepositoriesPass;
use Netzmacht\Contao\Toolkit\Bundle\DependencyInjection\Compiler\TranslatorPass;
use Netzmacht\Contao\Toolkit\Bundle\NetzmachtContaoToolkitBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class NetzmachtContaoToolkitBundleSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NetzmachtContaoToolkitBundle::class);
    }

    public function it_registers_translator_pass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(Argument::type(TranslatorPass::class))->shouldBeCalledOnce();
        $container->addCompilerPass(Argument::any())->shouldBeCalled();

        $this->build($container);
    }

    public function it_registers_repositories_pass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(Argument::type(RepositoriesPass::class))->shouldBeCalledOnce();
        $container->addCompilerPass(Argument::any())->shouldBeCalled();

        $this->build($container);
    }

    public function it_registers_fos_cache_response_tagger_pass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(Argument::type(FosCacheResponseTaggerPass::class))->shouldBeCalledOnce();
        $container->addCompilerPass(Argument::any())->shouldBeCalled();

        $this->build($container);
    }

    public function it_registers_hook_listener_pass_for_contao_44(ContainerBuilder $container): void
    {
        $this->beConstructedWith('4.4.0@123');

        $container->addCompilerPass(Argument::type(RegisterHooksPass::class))->shouldBeCalledOnce();
        $container->addCompilerPass(Argument::any())->shouldBeCalled();

        $this->build($container);
    }

    public function it_doesnt_register_hook_listener_pass_for_contao_45_and_up(
        ContainerBuilder $container
    ): void {
        $this->beConstructedWith('4.5.0@123');

        $container->addCompilerPass(Argument::type(RegisterHooksPass::class))->shouldNotBeCalled();
        $container->addCompilerPass(Argument::any())->shouldBeCalled();

        $this->build($container);
    }
}
