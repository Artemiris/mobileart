<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class EventType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string $eventTypeTerm
     */
    public $eventTypeTerm;

    /**
     * @var ActorInRoleType $actor
     */
    public $actor;

    /**
     * @var string $date
     */
    public $date;

    /**
     * EventType constructor.
     * @param string $eventTypeTerm
     * @param ActorInRoleType $actor
     */
    public function __construct(string $eventTypeTerm, ActorInRoleType $actor, string $date)
    {
        $this->eventTypeTerm = $eventTypeTerm;
        $this->actor = $actor;
        $this->date = $date;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            'name'=>'lido:eventSet',
            'value'=>[
                'name'=>'lido:event',
                'value'=>[
                    [
                        'name'=>'lido:eventType',
                        'value'=>[
                            'name'=>'lido:term',
                            'value'=>$this->eventTypeTerm
                        ]
                    ],
                    [
                        'name'=>'lido:eventActor',
                        'value'=>$this->actor
                    ],
                    [
                        'name'=>'lido:eventDate',
                        'value'=>[
                            'name'=>'lido:date',
                            'value'=>[
                                [
                                    'name'=>'lido:earliestDate',
                                    'value'=>$this->date
                                ],
                                [
                                    'name'=>'lido:latestDate',
                                    'value'=>$this->date
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}