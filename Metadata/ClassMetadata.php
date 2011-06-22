<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\SerializerBundle\Metadata;

use Metadata\MethodMetadata;
use Metadata\ClassMetadata as BaseClassMetadata;

class ClassMetadata extends BaseClassMetadata
{
    public $exclusionPolicy = 'NONE';
    public $preSerializeMethods = array();
    public $postDeserializeMethods = array();

    public function addPreSerializeMethod(MethodMetadata $method)
    {
        $this->preSerializeMethods[] = $method;
    }

    public function addPostDeserializeMethod(MethodMetadata $method)
    {
        $this->postDeserializeMethods[] = $method;
    }

    public function serialize()
    {
        return serialize(array(
            $this->exclusionPolicy,
            $this->preSerializeMethods,
            $this->postDeserializeMethods,
            parent::serialize(),
        ));
    }

    public function unserialize($str)
    {
        list(
            $this->exclusionPolicy,
            $this->preSerializeMethods,
            $this->postDeserializeMethods,
            $parentStr
        ) = unserialize($str);

        parent::unserialize($parentStr);
    }
}