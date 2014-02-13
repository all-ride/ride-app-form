<?php

namespace pallo\application\validation\validator;

use pallo\library\dependency\DependencyInjector;
use pallo\library\validation\validator\ImageValidator as LibImageValidator;

/**
 * Validator interface to perform extra processing after creating the validator
 */
class ImageValidator extends LibImageValidator implements DependencyValidator {

    /**
     * Hook to process a created validator
     * @param pallo\library\dependency\DependencyInjector $dependencyInjector
     * @return null
     */
    public function processValidator(DependencyInjector $dependencyInjector) {
        if (!$this->fileBrowser) {
            $this->setFileBrowser($dependencyInjector->get('pallo\\library\\system\\file\\browser\\FileBrowser'));
        }

        if (!$this->imageFactory) {
            $this->setImageFactory($dependencyInjector->get('pallo\\library\\image\\io\\ImageFactory'));
        }
    }

}