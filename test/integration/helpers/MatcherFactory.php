<?php

namespace Test\Integration\Helpers;

use Coduo\PHPMatcher\Lexer;
use Coduo\PHPMatcher\Matcher;
use Coduo\PHPMatcher\Parser;

class MatcherFactory
{
    /**
     * @return Matcher
     */
    public static function buildXmlMatcher(): Matcher
    {
        return self::buildMatcher(Matcher\XmlMatcher::class);
    }

    /**
     * @return Matcher
     */
    public static function buildJsonMatcher(): Matcher
    {
        return self::buildMatcher(Matcher\JsonMatcher::class);
    }

    /**
     * @param string $matcherClass
     *
     * @return Matcher
     */
    protected static function buildMatcher($matcherClass): Matcher
    {
        $orMatcher = self::buildOrMatcher();
        $chainMatcher = new Matcher\ChainMatcher(array(
            new $matcherClass($orMatcher),
        ));

        return new Matcher($chainMatcher);
    }

    /**
     * @return Matcher\ChainMatcher
     */
    protected static function buildOrMatcher(): Matcher\ChainMatcher
    {
        $scalarMatchers = self::buildScalarMatchers();
        $orMatcher = new Matcher\OrMatcher($scalarMatchers);
        $arrayMatcher = new Matcher\ArrayMatcher(
            new Matcher\ChainMatcher(array(
                $orMatcher,
                $scalarMatchers
            )),
            self::buildParser()
        );

        $chainMatcher = new Matcher\ChainMatcher(array(
            $orMatcher,
            $arrayMatcher,
        ));

        return $chainMatcher;
    }

    /**
     * @return Matcher\ChainMatcher
     */
    protected static function buildScalarMatchers(): Matcher\ChainMatcher
    {
        $parser = self::buildParser();

        return new Matcher\ChainMatcher(array(
            new Matcher\CallbackMatcher(),
            new Matcher\ExpressionMatcher(),
            new Matcher\NullMatcher(),
            new Matcher\StringMatcher($parser),
            new Matcher\IntegerMatcher($parser),
            new Matcher\BooleanMatcher(),
            new Matcher\DoubleMatcher($parser),
            new Matcher\NumberMatcher(),
            new Matcher\ScalarMatcher(),
            new Matcher\WildcardMatcher()
        ));
    }

    /**
     * @return Parser
     */
    protected static function buildParser(): Parser
    {
        return new Parser(new Lexer(), new Parser\ExpanderInitializer());
    }
}
