<?php

namespace Acme\DemoBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;

class ApiSyncAnnotationSubscriber implements EventSubscriber
{
    const API_SYNC_ENTITY_ANNOTATION_META = 'Acme\DemoBundle\Annotation\ApiSyncEntity';

    const API_SYNC_ENTITY_ANNOTATION_CONTENT = 'Acme\DemoBundle\Annotation\ApiSyncContent';

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $reader = new AnnotationReader;
        $entityClass = get_class($args->getEntity());
        $apySyncEntityAnnotation = $reader->getClassAnnotation(new \ReflectionClass($entityClass), self::API_SYNC_ENTITY_ANNOTATION_META);
        if (! empty($apySyncEntityAnnotation)) {
            $entity = $apySyncEntityAnnotation->getEntity();

            // Manage business logic
            $this->handlePostEventsApiSync($args, $entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @param $entity
     */
    protected function handlePostEventsApiSync(LifecycleEventArgs $args, $entity)
    {
        // do something cool!
        $reader = new AnnotationReader;
        $class = new \ReflectionClass(get_class($args->getEntity()));
        $data = [];

        foreach ($class->getProperties() as $reflectionProperty) {
            $annotation = $reader->getPropertyAnnotation($reflectionProperty, self::API_SYNC_ENTITY_ANNOTATION_CONTENT);

            if (null !== $annotation) {
                $property = $reflectionProperty->getName();
                $entity = $args->getEntity();
                if (property_exists($entity, $property)) {
                    $getter = sprintf('get%s', ucfirst($property));
                    $value = $entity->$getter();
                    $apiName = $annotation->getName();
                    if (empty($value) && $annotation->getRequired()) {
                        $defaultValue = $annotation->getDefault();
                        $value = isset($defaultValue)
                            ? $defaultValue
                            : 'EMPTY_VALUE';
                    }

                    $data[] = ['name' => $apiName, 'value' => $value];
                }
            }
        }

        if (count($data) > 0) {
            $this->publish($args, $lead, 'newContact', 'MyCustomEvent');
        }
    }
}