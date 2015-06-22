<?php
/**
 * Created by PhpStorm.
 * User: Glauber
 * Date: 26/01/15
 * Time: 13:47
 */

namespace Base\BaseBundle\Entity;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\DefaultNamingStrategy;

class AbstractEntity
{
    public static $manageEntity = array();

    /**
     * @param array $params
     * @return $this
     */
    public function populate(array $params = array(), $lazy = true)
    {
        if (!$lazy) {
            $reflection = new \ReflectionClass(get_class($this));

            foreach ($reflection->getProperties() as $refPropertie) {
                $manyToOne = strstr($refPropertie->getDocComment(), '@ORM\ManyToOne');
                $oneToOne  = strstr($refPropertie->getDocComment(), '@ORM\OneToOne');

                if ($manyToOne || $oneToOne) {
                    if ($manyToOne) {
                        $annotation = $manyToOne;
                    } else {
                        $annotation = $oneToOne;
                    }

                    $annotation = str_replace('targetEntity="', '#', $annotation);
                    $annotation = substr($annotation, strpos($annotation, '#'));
                    $annotation = substr($annotation, 1, strpos($annotation, '"') - 1);

                    $method = 'set' . ucfirst($refPropertie->getName());

                    $class = new $annotation;

                    if (!in_array($annotation, self::$manageEntity)) {
                        array_push(self::$manageEntity, $annotation);

                        $class->populate($params, false);
                        $this->{$method}($class);
                    }
                }
            }
        }

        foreach ($params as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (false === strpos(strtolower($key), 'id')) {
                if (method_exists($this, $method)) {
                    $this->{$method}($value);
                }
            }
        }

        return $this;
    }

    /**
     * @param null $parent
     * @return array
     */
    public function toArray($parent = null)
    {
        $data    = array();
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if ('get' === substr($method, 0, 3)) {
                $value = $this->$method();
                if (\is_array($value)) {
                    $subvalues = array();
                    foreach ($value as $key => $subvalue) {
                        if ($subvalue instanceof AbstractBase && $parent != $subvalue) {
                            $subvalues[$key] = $subvalue->toArray($this);
                        } else
                            if ($value instanceof \DateTime) {
                                $subvalue = $subvalue->format('Y-m-d h:m:i');
                            } else
                                if (is_object($subvalue) && $parent != $subvalue) {
                                    $subvalues[$key] = $subvalue->toString();
                                } else
                                    if ($parent != $subvalue) {
                                        $subvalues[$key] = $subvalue;
                                    }
                    }
                    $value = $subvalues;
                }
                if ($value instanceof AbstractBase && $parent != $value) {
                    $value = $value->toArray($this);
                } else
                    if ($value instanceof \DateTime) {
                        $value = $value->format('Y-m-d h:m:i');
                    } else
                        if (is_object($value) && $parent != $value) {
                            $value = $value->toString();
                        }

                if (!$parent || ($parent && (($value instanceof AbstractBase && $parent != $value) || !($value instanceof AbstractBase)))) {
                    $data[lcfirst(substr($method, 3))] = $value;
                }
            }
        }

        return $data;
    }
} 