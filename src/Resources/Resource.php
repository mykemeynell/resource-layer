<?php

namespace ResourceLayer\Resources;

abstract class Resource implements
    Contracts\WithActionButtons,
    Contracts\WithController,
    Contracts\WithNavigation,
    Contracts\WithRequests,
    Contracts\WithResourceType
{
    use Concerns\HasActionButtons;
    use Concerns\HasController;
    use Concerns\HasNavigation;
    use Concerns\HasRequests;
    use Concerns\HasResourceType;
}
