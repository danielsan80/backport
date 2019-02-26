<?php

namespace BackPort;

use BackPort\Visitors\CastScalarMethodReturn;
use BackPort\Visitors\RemoveMethodNullableReturnType;
use BackPort\Visitors\RemoveMethodReturnType;
use BackPort\Visitors\RemoveMethodVoidReturnType;
use BackPort\Visitors\RemoveParamNullableType;
use BackPort\Visitors\RemoveParamScalarType;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

class Backporter
{

    public function port($code)
    {

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse($code);

        $traverser = new NodeTraverser();
//        $traverser->addVisitor(new RemoveMethodNullableReturnType());
//        $traverser->addVisitor(new RemoveMethodVoidReturnType());
        $traverser->addVisitor(new CastScalarMethodReturn());
        $traverser->addVisitor(new RemoveMethodReturnType());
        $traverser->addVisitor(new RemoveParamNullableType());
        $traverser->addVisitor(new RemoveParamScalarType());

        $dumper = new NodeDumper;
        $beforeDump = $dumper->dump($ast);

//        echo $beforeDump;

        $ast = $traverser->traverse($ast);

        $afterDump = $dumper->dump($ast);

        if ($beforeDump != $afterDump) {

            $prettyPrinter = new PrettyPrinter\Standard;

            $code = $prettyPrinter->prettyPrintFile($ast);

        }

        return $code;

    }


}