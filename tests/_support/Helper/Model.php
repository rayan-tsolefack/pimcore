<?php

namespace Pimcore\Tests\Helper;

use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\Fieldcollection\Definition;

class Model extends AbstractDefinitionHelper
{
    /**
     * @inheritDoc
     */
    public function _beforeSuite($settings = [])
    {
        AbstractObject::setHideUnpublished(false);
        parent::_beforeSuite($settings);
    }

    /**
     * Set up a class which contains a classification store field
     *
     * @param array $params
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     */
    public function setupPimcoreClass_Csstore($params = [], $name = 'csstore', $filename = 'classificationstore.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $csField = $this->createDataChild('classificationstore', 'csstore');
            $csField->setStoreId($params['storeId']);
            $panel->addChild($csField);

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename);
        }

        return $class;
    }

    /**
     * Set up a class used for lazy loading tests.
     *
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     *
     * @throws \Exception
     */
    public function setupPimcoreClass_LazyLoading($name = 'LazyLoading', $filename = 'lazyloading/class_LazyLoading_export.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('manyToManyObjectRelation', 'objects')
                ->setClasses(['RelationTest'])
            );

            $panel->addChild($this->createDataChild('manyToOneRelation', 'relation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'relations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'advancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyRelation', 'advancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'meta'],
                ]));

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');

            $lFields->addChild($this->createDataChild('manyToManyObjectRelation', 'lobjects')
                ->setClasses(['RelationTest'])
            );

            $lFields->addChild($this->createDataChild('manyToOneRelation', 'lrelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('manyToManyRelation', 'lrelations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'ladvancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $lFields->addChild($this->createDataChild('advancedManyToManyRelation', 'ladvancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'meta'],
                ]));

            $lFields->addChild($this->createDataChild('manyToManyObjectRelation', 'lobjects')
                ->setClasses(['RelationTest'])
            );

            $block = new ClassDefinition\Data\Block();
            $block->setName('testblock');

            $block->addChild($this->createDataChild('manyToManyObjectRelation', 'blockobjects')
                ->setClasses(['RelationTest'])
            );

            $block->addChild($this->createDataChild('manyToOneRelation', 'blockrelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $block->addChild($this->createDataChild('manyToManyRelation', 'blockrelations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $block->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'blockadvancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $block->addChild($this->createDataChild('advancedManyToManyRelation', 'blockadvancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $blockLazyLoaded = new ClassDefinition\Data\Block();
            $blockLazyLoaded->setName('testblockLazyloaded');
            $blockLazyLoaded->setLazyLoading(true);

            $blockLazyLoaded->addChild($this->createDataChild('manyToManyObjectRelation', 'blockobjectsLazyLoaded')
                ->setClasses(['RelationTest'])
            );

            $blockLazyLoaded->addChild($this->createDataChild('manyToOneRelation', 'blockrelationLazyLoaded')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $blockLazyLoaded->addChild($this->createDataChild('manyToManyRelation', 'blockrelationsLazyLoaded')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $blockLazyLoaded->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'blockadvancedObjectsLazyLoaded')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $blockLazyLoaded->addChild($this->createDataChild('advancedManyToManyRelation', 'blockadvancedRelationsLazyLoaded')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($lFields);
            $panel->addChild($block);
            $panel->addChild($blockLazyLoaded);

            $panel->addChild($this->createDataChild('fieldcollections', 'fieldcollection')
                ->setAllowedTypes(['LazyLoadingTest', 'LazyLoadingLocalizedTest']));

            $panel->addChild($this->createDataChild('objectbricks', 'bricks'));

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename, true, 'LL');
        }

        return $class;
    }

    /**
     * Set up a class used for relation tests.
     *
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     *
     * @throws \Exception
     */
    public function setupPimcoreClass_RelationTest($name = 'RelationTest', $filename = 'relations/class_RelationTest_export.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('input', 'someAttribute'));
            $panel->addChild($this->createDataChild('input', 'someAttribute1'));
            $panel->addChild($this->createDataChild('input', 'someAttribute2'));
            $panel->addChild($this->createDataChild('input', 'someAttribute3'));
            $panel->addChild($this->createDataChild('input', 'someAttribute4'));

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');
            $lFields->addChild($this->createDataChild('input', 'xsomeAttribute'));
            $lFields->addChild($this->createDataChild('input', 'xsomeAttribute1'));
            $lFields->addChild($this->createDataChild('input', 'xsomeAttribute2'));
            $lFields->addChild($this->createDataChild('input', 'xsomeAttribute3'));
            $lFields->addChild($this->createDataChild('input', 'xsomeAttribute4'));
            $panel->addChild($lFields);

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename);
        }

        return $class;
    }

    /**
     * Set up a class used for relation tests.
     *
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     *
     * @throws \Exception
     */
    public function setupPimcoreClass_MultipleAssignments($name = 'MultipleAssignments', $filename = 'relations/class_MultipleAssignments_export.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('advancedManyToManyRelation', 'onlyOneManyToMany')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyRelation', 'multipleManyToMany')
                ->setAllowMultipleAssignments(true)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'onlyOneManyToManyObject')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'multipleManyToManyObject')
                ->setAllowMultipleAssignments(true)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'meta', 'type' => 'text', 'label' => 'meta'],
                ]));

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename, true);
        }

        return $class;
    }

    /**
     * Set up a class which (hopefully) contains all data types
     *
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     *
     * @throws \Exception
     */
    public function setupPimcoreClass_Unittest($name = 'unittest', $filename = 'class-import.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('date'));
            $panel->addChild($this->createDataChild('manyToOneRelation', 'lazyHref')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'lazyMultihref')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyObjectRelation', 'lazyObjects')
                ->setClasses([]));

            $panel->addChild($this->createDataChild('manyToOneRelation', 'href')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'multihref')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyObjectRelation', 'objects')
                ->setClasses([]));

            //TODO add test

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'objectswithmetadata')
                ->setAllowedClassId($name)
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'meta1', 'type' => 'text', 'label' => 'label1'],
                    ['position' => 2, 'key' => 'meta2', 'type' => 'text', 'label' => 'label2'], ]));

            $panel->addChild($this->createDataChild('slider'));
            $panel->addChild($this->createDataChild('numeric', 'number'));
            $panel->addChild($this->createDataChild('geopoint', 'point'));
            $panel->addChild($this->createDataChild('geobounds', 'bounds'));
            $panel->addChild($this->createDataChild('geopolygon', 'poly'));
            $panel->addChild($this->createDataChild('datetime'));
            $panel->addChild($this->createDataChild('time'));
            $panel->addChild($this->createDataChild('input'));
            $panel->addChild($this->createDataChild('password'));
            $panel->addChild($this->createDataChild('textarea'));
            $panel->addChild($this->createDataChild('wysiwyg'));
            $panel->addChild($this->createDataChild('select')->setOptions([
                ['key' => 'Selection 1', 'value' => '1'],
                ['key' => 'Selection 2', 'value' => '2'], ]));

            $panel->addChild($this->createDataChild('multiselect')->setOptions([
                ['key' => 'Katze', 'value' => 'cat'],
                ['key' => 'Kuh', 'value' => 'cow'],
                ['key' => 'Tiger', 'value' => 'tiger'],
                ['key' => 'Schwein', 'value' => 'pig'],
                ['key' => 'Esel', 'value' => 'donkey'],
                ['key' => 'Affe', 'value' => 'monkey'],
                ['key' => 'Huhn', 'value' => 'chicken'],
            ]));

            $panel->addChild($this->createDataChild('country'));
            $panel->addChild($this->createDataChild('countrymultiselect', 'countries'));
            $panel->addChild($this->createDataChild('language', 'languagex'));
            $panel->addChild($this->createDataChild('languagemultiselect', 'languages'));
            $panel->addChild($this->createDataChild('user'));
            $panel->addChild($this->createDataChild('link'));
            $panel->addChild($this->createDataChild('image'));
            $panel->addChild($this->createDataChild('hotspotimage'));
            $panel->addChild($this->createDataChild('checkbox'));
            $panel->addChild($this->createDataChild('booleanSelect'));
            $panel->addChild($this->createDataChild('table'));
            $panel->addChild($this->createDataChild('structuredTable', 'structuredtable')
                ->setCols([
                    ['position' => 1, 'key' => 'col1', 'type' => 'number', 'label' => 'collabel1'],
                    ['position' => 2, 'key' => 'col2', 'type' => 'text', 'label' => 'collabel2'],
                ])
                ->setRows([
                    ['position' => 1, 'key' => 'row1', 'label' => 'rowlabel1'],
                    ['position' => 2, 'key' => 'row2', 'label' => 'rowlabel2'],
                    ['position' => 3, 'key' => 'row3', 'label' => 'rowlabel3'],
                ])
            );
            $panel->addChild($this->createDataChild('fieldcollections', 'fieldcollection')
                ->setAllowedTypes(['unittestfieldcollection']));
            $panel->addChild($this->createDataChild('reverseManyToManyObjectRelation', 'nonowner'));
            $panel->addChild($this->createDataChild('fieldcollections', 'myfieldcollection')
                ->setAllowedTypes(['unittestfieldcollection']));

            $panel->addChild($this->createDataChild('urlSlug')->setAction('MyController::myAction'));
            $panel->addChild($this->createDataChild('urlSlug', 'urlSlug2')->setAction('MyController::myAction'));

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');
            $lFields->addChild($this->createDataChild('input', 'linput'));
            $lFields->addChild($this->createDataChild('textarea', 'ltextarea'));
            $lFields->addChild($this->createDataChild('wysiwyg', 'lwysiwyg'));
            $lFields->addChild($this->createDataChild('numeric', 'lnumber'));
            $lFields->addChild($this->createDataChild('slider', 'lslider'));
            $lFields->addChild($this->createDataChild('date', 'ldate'));
            $lFields->addChild($this->createDataChild('datetime', 'ldatetime'));
            $lFields->addChild($this->createDataChild('time', 'ltime'));
            $lFields->addChild($this->createDataChild('select', 'lselect')->setOptions([
                ['key' => 'one', 'value' => '1'],
                ['key' => 'two', 'value' => '2'], ]));

            $lFields->addChild($this->createDataChild('multiselect', 'lmultiselect')->setOptions([
                ['key' => 'one', 'value' => '1'],
                ['key' => 'two', 'value' => '2'], ]));
            $lFields->addChild($this->createDataChild('countrymultiselect', 'lcountries'));
            $lFields->addChild($this->createDataChild('languagemultiselect', 'llanguages'));
            $lFields->addChild($this->createDataChild('table', 'ltable'));
            $lFields->addChild($this->createDataChild('image', 'limage'));
            $lFields->addChild($this->createDataChild('checkbox', 'lcheckbox'));
            $lFields->addChild($this->createDataChild('link', 'llink'));
            $lFields->addChild($this->createDataChild('manyToManyObjectRelation', 'lobjects')
                ->setClasses([]));

            $lFields->addChild($this->createDataChild('manyToManyRelation', 'lmultihrefLazy')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('urlSlug', 'lurlSlug')->setAction('MyController::myLocalizedAction'));

            $panel->addChild($lFields);
            $panel->addChild($this->createDataChild('objectbricks', 'mybricks'));

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename);
        }

        return $class;
    }

    /**
     * Used for inheritance tests
     *
     * @param string $name
     * @param string $filename
     *
     * @return ClassDefinition|null
     *
     * @throws \Exception
     */
    public function setupPimcoreClass_Inheritance($name = 'inheritance', $filename = 'inheritance.json')
    {

        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$class = $cm->getClass($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');
            $lFields->addChild($this->createDataChild('input'));
            $lFields->addChild($this->createDataChild('textarea'));
            $lFields->addChild($this->createDataChild('wysiwyg'));

            $otherPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('Layout');
            $otherPanel->addChild($this->createDataChild('input', 'normalinput'));
            $otherPanel->addChild($this->createDataChild('image', 'yx'));
            $otherPanel->addChild($this->createDataChild('slider'));
            $otherPanel->addChild($this->createDataChild('manyToManyObjectRelation', 'relationobjects')
                ->setClasses([]));
            $panel->addChild($this->createDataChild('manyToOneRelation', 'relation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($lFields);
            $panel->addChild($otherPanel);
            $panel->addChild($this->createDataChild('objectbricks', 'mybricks'));

            $root->addChild($rootPanel);
            $class = $this->createClass($name, $root, $filename, true);
        }

        return $class;
    }

    /**
     * @param string $name
     * @param ClassDefinition\Layout $layout
     * @param string $filename
     * @param bool $inheritanceAllowed
     * @param string|null $id
     *
     * @return ClassDefinition
     */
    protected function createClass($name, $layout, $filename, $inheritanceAllowed = false, $id = null)
    {
        $cm = $this->getClassManager();
        $def = new ClassDefinition();

        if ($id !== null) {
            $def->setId($id);
        }
        $def->setName($name);
        $def->setLayoutDefinitions($layout);
        $def->setAllowInherit($inheritanceAllowed);
        $json = ClassDefinition\Service::generateClassDefinitionJson($def);
        $cm->saveJson($filename, $json);

        return $cm->setupClass($name, $filename);
    }

    /**
     * Sets up a Fieldcollection
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupFieldcollection_Unittestfieldcollection($name = 'unittestfieldcollection', $filename = 'fieldcollection-import.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getFieldcollection($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('input', 'fieldinput1'));
            $panel->addChild($this->createDataChild('input', 'fieldinput2'));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'fieldRelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'fieldLazyRelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');

            $lFields->addChild($this->createDataChild('Input', 'linput'));

            $lFields->addChild($this->createDataChild('manyToOneRelation', 'lrelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($lFields);

            $root->addChild($rootPanel);
            $definition = $this->createFieldcollection($name, $root, $filename);
        }

        return $definition;
    }

    /**
     * Sets up a Fieldcollection for lazy loading tests
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupFieldcollection_LazyLoadingTest($name = 'LazyLoadingTest', $filename = 'lazyloading/fieldcollection_LazyLoadingTest_export.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getFieldcollection($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('manyToManyObjectRelation', 'objects')
                ->setClasses(['RelationTest'])
            );

            $panel->addChild($this->createDataChild('manyToOneRelation', 'relation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'relations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'advancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyRelation', 'advancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'meta'],
                ]));

            $root->addChild($rootPanel);
            $definition = $this->createFieldcollection($name, $root, $filename);
        }

        return $definition;
    }

    /**
     * Sets up a Fieldcollection for localized lazy loading tests
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupFieldcollection_LazyLoadingLocalizedTest($name = 'LazyLoadingLocalizedTest', $filename = 'lazyloading/fieldcollection_LazyLoadingLocalizedTest_export.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getFieldcollection($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');

            $lFields->addChild($this->createDataChild('manyToManyObjectRelation', 'lobjects')
                ->setClasses(['RelationTest'])
            );

            $lFields->addChild($this->createDataChild('manyToOneRelation', 'lrelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('manyToManyRelation', 'lrelations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'ladvancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $lFields->addChild($this->createDataChild('advancedManyToManyRelation', 'ladvancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($lFields);

            $root->addChild($rootPanel);
            $definition = $this->createFieldcollection($name, $root, $filename);
        }

        return $definition;
    }

    /**
     * Sets up an object brick used for lazy loading tests
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupObjectbrick_LazyLoadingTest($name = 'LazyLoadingTest', $filename = 'lazyloading/objectbrick_LazyLoadingTest_export.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getObjectbrick($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('manyToManyObjectRelation', 'objects')
                ->setClasses(['RelationTest'])
            );

            $panel->addChild($this->createDataChild('manyToOneRelation', 'relation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'relations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $panel->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'advancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $panel->addChild($this->createDataChild('advancedManyToManyRelation', 'advancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadataUpper', 'type' => 'text', 'label' => 'meta'],
                ]));

            $root->addChild($rootPanel);
            $definition = $this->createObjectbrick($name, $root, $filename, [
                ['classname' => 'LazyLoading', 'fieldname' => 'bricks'],

            ]);
        }

        return $definition;
    }

    /**
     * Sets up an object brick used for lazy loading tests
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupObjectbrick_LazyLoadingLocalizedTest($name = 'LazyLoadingLocalizedTest', $filename = 'lazyloading/objectbrick_LazyLoadingLocalizedTest_export.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getObjectbrick($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $lFields = new \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields();
            $lFields->setName('localizedfields');

            $lFields->addChild($this->createDataChild('manyToManyObjectRelation', 'lobjects')
                ->setClasses(['RelationTest'])
            );

            $lFields->addChild($this->createDataChild('manyToOneRelation', 'lrelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('manyToManyRelation', 'lrelations')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true));

            $lFields->addChild($this->createDataChild('advancedManyToManyObjectRelation', 'ladvancedObjects')
                ->setAllowMultipleAssignments(false)
                ->setAllowedClassId('RelationTest')
                ->setClasses([])
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'metadata'],
                ]));

            $lFields->addChild($this->createDataChild('advancedManyToManyRelation', 'ladvancedRelations')
                ->setAllowMultipleAssignments(false)
                ->setDocumentTypes([])->setAssetTypes([])->setClasses(['RelationTest'])
                ->setDocumentsAllowed(false)->setAssetsAllowed(false)->setObjectsAllowed(true)
                ->setColumns([ ['position' => 1, 'key' => 'metadata', 'type' => 'text', 'label' => 'meta'],
                ]));

            $panel->addChild($lFields);
            $root->addChild($rootPanel);
            $definition = $this->createObjectbrick($name, $root, $filename, [
                ['classname' => 'LazyLoading', 'fieldname' => 'bricks'],

            ]);
        }

        return $definition;
    }

    /**
     * Sets up an object brick
     *
     * @param string $name
     * @param string $filename
     *
     * @return Definition|null
     *
     * @throws \Exception
     */
    public function setupObjectbrick_UnittestBrick($name = 'unittestBrick', $filename = 'brick-import.json')
    {
        /** @var ClassManager $cm */
        $cm = $this->getClassManager();

        if (!$definition = $cm->getObjectbrick($name)) {
            $root = new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel('root');
            $panel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel())->setName('MyLayout');
            $rootPanel = (new \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel())->setName('Layout');
            $rootPanel->addChild($panel);

            $panel->addChild($this->createDataChild('input', 'brickinput'));

            $panel->addChild($this->createDataChild('input', 'brickinput2'));

            $panel->addChild($this->createDataChild('manyToManyRelation', 'brickLazyRelation')
                ->setDocumentTypes([])->setAssetTypes([])->setClasses([])
                ->setDocumentsAllowed(true)->setAssetsAllowed(true)->setObjectsAllowed(true));

            $root->addChild($rootPanel);
            $definition = $this->createObjectbrick($name, $root, $filename, [
                ['classname' => 'unittest', 'fieldname' => 'mybricks'],
                ['classname' => 'inheritance', 'fieldname' => 'mybricks'],
            ]);
        }

        return $definition;
    }

    /**
     * @param string $name
     * @param ClassDefinition\Layout $layout
     * @param string $filename
     *
     * @return Definition
     */
    protected function createFieldcollection($name, $layout, $filename)
    {
        $cm = $this->getClassManager();
        $def = new Definition();
        $def->setKey($name);
        $def->setLayoutDefinitions($layout);
        $json = ClassDefinition\Service::generateFieldCollectionJson($def);
        $cm->saveJson($filename, $json);

        return $cm->setupFieldcollection($name, $filename);
    }

    /**
     * @param string $name
     * @param ClassDefinition\Layout $layout
     * @param string $filename
     * @param array $classDefinitions
     *
     * @return \Pimcore\Model\DataObject\Objectbrick\Definition
     */
    protected function createObjectbrick($name, $layout, $filename, $classDefinitions = [])
    {
        $cm = $this->getClassManager();
        $def = new \Pimcore\Model\DataObject\Objectbrick\Definition();
        $def->setKey($name);
        $def->setLayoutDefinitions($layout);
        $def->setClassDefinitions($classDefinitions);
        $json = ClassDefinition\Service::generateObjectBrickJson($def);
        $cm->saveJson($filename, $json);

        return $cm->setupObjectbrick($name, $filename);
    }

    /**
     * Initialize widely used class definitions
     */
    public function initializeDefinitions()
    {
        $cm = $this->getClassManager();

        $this->setupFieldcollection_Unittestfieldcollection();

        $this->setupPimcoreClass_Unittest();
        $this->setupPimcoreClass_Inheritance();
        $this->setupPimcoreClass_RelationTest();

        $this->setupObjectbrick_UnittestBrick();
    }
}
