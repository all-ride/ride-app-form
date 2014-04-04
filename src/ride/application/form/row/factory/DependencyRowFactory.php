<?php

namespace ride\application\form\row\factory;

use ride\library\dependency\exception\DependencyException;
use ride\library\dependency\DependencyInjector;
use ride\library\form\exception\FormException;
use ride\library\form\row\factory\AbstractRowFactory;
use ride\library\form\row\FileRow;

/**
 * Factory to create row types through dependency injection
 */
class DependencyRowFactory extends AbstractRowFactory {

    /**
     * Instance of the dependency injector
     * @var \ride\library\dependency\DependencyInjector
     */
    protected $dependencyInjector;

    /**
     * Constructs a new dependency injector
     * @param \ride\library\dependency\DependencyInjector $dependencyInjector
     * Instance of the dependency injector
     * @return null
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * Creates a row
     * @param string $type Name of the row type
     * @param string $name Name of the row
     * @param array $options Extra options for the row
     * @return ride\library\form\row\Row
     */
    public function createRow($type, $name, $options) {
        $arguments = array(
            'name' => $name,
            'options' => $options,
        );

        try {
            $row = $this->dependencyInjector->get('ride\\library\\form\\row\\Row', $type, $arguments, true);
        } catch (DependencyException $exception) {
            throw new FormException('Could not create row for ' . $name . ': ' . $exception->getMessage(), 0, $exception);
        }

        if ($row instanceof FileRow) {
            foreach ($this->absolutePaths as $absolutePath => $null) {
                $row->addAbsolutePath($absolutePath);
            }
        }

        return $row;
    }

}
