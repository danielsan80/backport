<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveMethodReturnType extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Stmt\ClassMethod) {
            return;
        }
        $node->returnType = null;
    }

}