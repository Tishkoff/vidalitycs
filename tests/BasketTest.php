<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Vidalitycs\Infrastructure\ICatalogGateway;
use Vidalitycs\Infrastructure\IDeliveryChargeRulesGateway;
use Vidalitycs\Infrastructure\IOffersGateway;
use Vidalitycs\Infrastructure\Kernel;

class BasketTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|ICatalogGateway
     */
    private $catalogGatewayMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|IOffersGateway
     */
    private $offersGatewayMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|IDeliveryChargeRulesGateway
     */
    private $deliveryChargeRulesGatewayMock;

    protected function setUp(): void
    {
        $this->catalogGatewayMock = $this->createMock(ICatalogGateway::class);
        $this->catalogGatewayMock->expects(self::once())
            ->method('getCatalog')
            ->willReturn([
                    ['code' => 'R01', 'name' => 'Red Widget', 'price' => '32.95'],
                    ['code' => 'G01', 'name' => 'Green Widget', 'price' => '24.95'],
                    ['code' => 'B01', 'name' => 'Blue Widget', 'price' => '7.95'],
                ]
            );

        $this->offersGatewayMock = $this->createMock(IOffersGateway::class);
        $this->offersGatewayMock->expects(self::once())
            ->method('getOffers')
            ->willReturn([
                    [
                        'source_product_code' => 'R01',
                        'product_quantity' => '2',
                        'target_product_code' => 'R01',
                        'target_product_quantity' => '2',
                        'discount_percentage' => '25',
                    ],
                ]
            );

        $this->deliveryChargeRulesGatewayMock = $this->createMock(IDeliveryChargeRulesGateway::class);
        $this->deliveryChargeRulesGatewayMock->expects(self::once())
            ->method('getDeliveryChargeRules')
            ->willReturn([
                    ['valid_from_amount' => '00.00', 'fee' => '4.95'],
                    ['valid_from_amount' => '50.00', 'fee' => '2.95'],
                    ['valid_from_amount' => '90.00', 'fee' => '0.00'],
                ]
            );
    }

    public function exampleProvider(): array
    {
        return [
            [['B01', 'G01'], '37.85'],
            [['R01', 'R01'], '54.37'],
            [['R01', 'G01'], '60.85'],
            [['B01', 'B01', 'R01', 'R01', 'R01'], '98.27'],
        ];
    }

    /**
     * @dataProvider exampleProvider
     * @covers      \Vidalitycs\Infrastructure\Kernel
     *
     * @param $items
     * @param $expectedTotal
     */
    public function testBasket($items, $expectedTotal): void
    {
        $kernel = new Kernel(
            $this->catalogGatewayMock,
            $this->offersGatewayMock,
            $this->deliveryChargeRulesGatewayMock
        );

        $application = $kernel->getApplication();
        $total = $application->addItemsToBasket($items);

        self::assertEquals($expectedTotal, $total);
    }
}


