<?php


namespace common\utility\lido;


use Sabre\Xml\Writer;

class ActorInRoleType implements \Sabre\Xml\XmlSerializable
{
    /**
     * @var string $type person|organization
     */
    public $type;

    /**
     * @var string role actor role
     */
    public $role;

    /**
     * @var AppellationValueType[] $names
     */
    public $names = [];

    /**
     * ActorInRoleType constructor.
     * @param string $type
     * @param string $role
     * @param AppellationValueType[] $names
     */
    public function __construct(string $type, string $role, array $names)
    {
        $this->type = $type;
        $this->role = $role;
        $this->names = $names;
    }

    /**
     * @inheritDoc
     */
    public function xmlSerialize(Writer $writer)
    {
        $content = [
            'name'=>'lido:actorInRole',
            'value'=>[
                [
                    'name'=>'lido:actor',
                    'value'=> []
                ],
                [
                    'name'=>'lido:roleActor',
                    'value'=>[
                        'name'=>'lido:term',
                        'value'=>$this->role
                    ]
                ]
            ]
        ];

        foreach ($this->names as $name)
        {
            $content['value'][0]['value'][] = [
                'name'=>'lido:nameActorSet',
                'value'=>$name
            ];
        }

        $writer->write($content);
    }
}