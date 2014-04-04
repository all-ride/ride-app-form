<?php

namespace ride\application\validation\validator;

use ride\library\dependency\DependencyInjector;
use ride\library\validation\validator\ImageValidator as LibImageValidator;

/**
 * Validator interface to perform extra processing after creating the validator
 */
class ImageValidator extends LibImageValidator implements DependencyValidator {

    /**
     * Hook to process a created validator
     * @param \ride\library\dependency\DependencyInjector $dependencyInjector
     * @return null
     */
    public function processValidator(DependencyInjector $dependencyInjector) {
        if (!$this->fileBrowser) {
            $this->setFileBrowser($dependencyInjector->get('ride\\library\\system\\file\\browser\\FileBrowser'));
        }

        if (!$this->imageFactory) {
            $this->setImageFactory($dependencyInjector->get('ride\\library\\image\\io\\ImageFactory'));
        }
    }

}