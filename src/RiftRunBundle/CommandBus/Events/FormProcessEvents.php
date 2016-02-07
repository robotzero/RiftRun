<?php

namespace RiftRunBundle\CommandBus\Events;

final class FormProcessEvents
{
    /**
     * hydrate event is thrown each time symfony form has processed new object.
     * @var string
     */
    const HYDRATE_FORM = 'hydrate.form';
}
