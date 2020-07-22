<?php

namespace App\Tests\Behat\Context\ReportTemplate\Adapter;

use App\Core\Model\ReportTemplate\ReportTemplateId;
use App\Core\Model\ReportTemplate\ReportTemplateInterface;
use App\Core\Repository\ReportTemplate\ReportTemplateQueryRepositoryInterface;
use App\Infrastructure\Adapter\ReportTemplate\ShortForGetOneReportTemplate as ReportTemplateShortForGetOneAdapter;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

class GetReportTemplateByIdAdapter implements Context
{
    /** @var array */
    private $predefinedData;
    /** @var ReportTemplateQueryRepositoryInterface */
    private $reportTemplateQueryRepository;
    /** @var ReportTemplateInterface */
    private $reportTemplate;
    /** @var array */
    private $reportTemplateAdaptedStructure;
    /** @var bool */
    private $result;

    /**
     * GetReportTemplateByIdAdapter constructor.
     * @param ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
     */
    public function __construct(
        ReportTemplateQueryRepositoryInterface $reportTemplateQueryRepository
    ) {
        $this->reportTemplateQueryRepository = $reportTemplateQueryRepository;
    }

    /**
     * @Given I'm set correct ReportTemplate data for short adapter
     */
    public function imSetCorrectReporttemplateDataForShortAdapter()
    {
        $this->reportTemplate = $this->reportTemplateQueryRepository->find(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba231')
        );
    }

    /**
     * @Given I'm set incorrect ReportTemplate data for short adapter
     */
    public function imSetIncorrectReporttemplateDataForShortAdapter()
    {
        $this->reportTemplate = $this->reportTemplateQueryRepository->find(
            new ReportTemplateId('6647e03a-4f98-4a25-acc7-0ebad8fba230')
        );
    }

    /**
     * @Given Create correct predefined data
     */
    public function createCorrectPredefinedData()
    {
        $this->reportTemplateAdaptedStructure = ReportTemplateShortForGetOneAdapter::adapt($this->reportTemplate);
        $this->reportTemplateAdaptedStructure =
            $this->objectToArray($this->reportTemplateAdaptedStructure["resultReportTemplate"]);

        $this->predefinedData["resultReportTemplate"] =
            [
                "id" => "6647e03a-4f98-4a25-acc7-0ebad8fba231",
                "name" => "Test",
                "serviceName" => "Sprinkler Service",
                "status" => "draft",
                "description" => "Fire Alarm System desciption",
                "sections" =>
                    [[
                        "id" => "6647e03a-4f98-4a25-acc7-0ebad8fba222",
                        "title" => "test",
                        "position" => 2,
                        "paragraphs" => [
                            [
                                "id" => "ac0cec75-b17d-4509-b15a-29621c41b17d",
                                "headerValue" => "Paragraph Title",
                                "position" => 1,
                                "level" => 1,
                                "parentId" => null,
                                "items" => null,
                                "children" => [
                                    [
                                        "id" => "ac0cec75-b17d-4509-b15a-29621c41b16d",
                                        "headerValue" => "Paragraph Title",
                                        "position" => 2,
                                        "level" => 2,
                                        "parentId" => "ac0cec75-b17d-4509-b15a-29621c41b17d",
                                        "items" => null,
                                        "children" => [
                                            [
                                                "id" => "ac0cec75-b17d-4509-b15a-29621c41b15d",
                                                "headerValue" => "Paragraph Title",
                                                "position" => 3,
                                                "level" => 3,
                                                "parentId" => "ac0cec75-b17d-4509-b15a-29621c41b16d",
                                                "items" => null,
                                                "children" => null,
                                                "device" => [
                                                    "id" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
                                                    "name" => "Sprinkler",
                                                    "level" => 1
                                                ],
                                                "filter" => [
                                                    "id" => "inspection",
                                                    "name" => "Related to an inspected device"
                                                ]
                                            ]
                                        ],
                                        "device" => [
                                            "id" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
                                            "name" => "Sprinkler",
                                            "level" => 1
                                        ],
                                        "filter" => [
                                            "id" => "inspection",
                                            "name" => "Related to an inspected device"
                                        ]
                                    ]
                                ],
                                "device" => [
                                    "id" => "63bea125-46f1-4d59-b6ec-65000d13ac1f",
                                    "name" => "Sprinkler",
                                    "level" => 1
                                ],
                                "filter" => [
                                    "id" => "inspection",
                                    "name" => "Related to an inspected device"
                                ]
                            ]
                        ]
                    ]
                    ]
            ];
    }

    /**
     * @param $data
     * @return array
     */
    public function objectToArray($data): array
    {
        $result = array();

        $data = (array) $data;
        foreach ($data as $key => $value) {
            $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
            if (is_object($value)) {
                $value = (array) $value;
            }
            if (is_array($value)) {
                $result[$key] = $this->objectToArray($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @When I compere ReportTemplateShortForGetOneAdapter data with predefined data
     */
    public function iCompereReporttemplateshortforgetoneadapterDataWithPredefinedData()
    {
        if (json_encode($this->reportTemplateAdaptedStructure, true) ===
            json_encode($this->predefinedData["resultReportTemplate"], true)) {
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    /**
     * @Then I should get the same structure
     */
    public function iShouldGetTheSameStructure()
    {
        Assert::assertEquals($this->result, true);
    }

    /**
     * @Then I should not get the same structure
     */
    public function iShouldNotGetTheSameStructure()
    {
        Assert::assertEquals($this->result, false);
    }
}
