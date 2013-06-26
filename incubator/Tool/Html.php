<?php

/**
 * A set of mildly useful html manipulation and inspection tools.
 */
class LC_Tool_Html
{
    /**
     * @var string $_html the raw html being processed
     */
    protected $_html = null;

    /**
     * @var array $_tokens the array of tokens representing the raw html
     */
    protected $_tokens = null;

    /**
     * Used to configure the object with an html formatted string which will be used for further processing
     */
    public function setHtml($html)
    {
        $this->_html = $html;
        $this->_tokens = null;
        return $this;
    }

    /**
     * Used to get the html that was previously set by a call to {@link setHtml()}
     */
    public function getHtml()
    {
        if (is_null($this->_html)) {
            throw new Exception ("You must first specify an html string to work with using " . __CLASS__ . "::setHtml'");
        }
        return $this->_html;
    }

    /**
     * Used to get the tokenized version of the raw html currently being processed.
     */
    public function getTokens()
    {
        if (is_null($this->_tokens)) {
            $this->_tokens = $this->_tokenize();
        }
        return $this->_tokens;
    }

    /**
     * Protected method to do the actual tokenization of the html
     */
    protected function _tokenize()
    {
        return preg_split('/(<[^>]*>)/', $this->getHtml(), null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    }

    /**
     * Used to check if a particular string is an html opening tag
     */
    public function isOpenTag($token)
    {
        return preg_match('/(<\s*[^\/][^>]*>)/', $token);
    }

    /**
     * Used to check if a particular string is an html closing tag
     */
    public function isCloseTag($token)
    {
        return preg_match('/(<\s*\/[^>]*>)/', $token);
    }

    /**
     * Used to check if a particular string is an html tag.  This is useful for detecting html self closing tags which will return true on this method, but false on {@link isOpenTag()} and {@link isCloseTag()}
     */
    public function isTag($token)
    {
        return preg_match('/(<[^>]*>)/', $token);
    }

    /**
     * Truncates a string after the closest whole word to the truncation length, but also safely retains HTML code.  By default it will append ellipses to the the string
     *
     * Conceptually this method uses a stack to keep up with open tags pushing and popping to that stack as open and close tags are encountered.  This is a nieve
     * implementation that expects valid html to work on.  Therefore if the original html has miss matched tags then this method will reflect those errors in the original
     * version of the html.
     *
     * @param int $truncateLength the length that the textual representation of the html should be truncated.
     * @param string $moreIndicator a string to append to the textual representation of the truncated html.
     * @return string html representing the truncated textual version of the original html
     */
    public function truncate($truncateLength = 12, $moreIndicator = '...')
    {
        $tokens = $this->getTokens();
        $openTagStack = array();
        $truncatedHtml = '';
        $textualLength = 0;
        foreach ($tokens as $token) {
            //if this token is an opening tag then push it to the open tag stack and append it to the truncated html
            if ($this->isOpenTag($token)) {
                array_unshift($openTagStack, $token);
                $truncatedHtml .= $token;
            } //if this token is a closing tag then pop from the open tag stack and append it to the truncated html
            else if ($this->isCloseTag($token)) {
                $openingTag = array_shift($openTagStack);
                $truncatedHtml .= $token;
            } //if this token is a tag, but not opening or closing we assume it's self closing tag then append this token to the truncatedHtml and continue
            else if ($this->isTag($token)) {
                $truncatedHtml .= $token;
            } //if this token is a text node then first divide it into individual words.  Append each of the words one at a time until the truncate length is passed or all of the words for this token have been added.
            else {
                foreach (preg_split('/([\s]+)/', $token, null, PREG_SPLIT_DELIM_CAPTURE) as $word) {
                    $truncatedHtml .= $word;
                    $textualLength += strlen($word);
                    if ($textualLength > $truncateLength) {
                        break;
                    }
                }
                if ($textualLength > $truncateLength) {
                    break;
                }
            }
        }
        $truncatedHtml .= $moreIndicator;
        foreach ($openTagStack as $token) {
            preg_match('/<\s*([^\s>]*)/', $token, $matches);
            $tagName = $matches[1];
            $truncatedHtml .= "</$tagName>";
        }

        return $truncatedHtml;
    }

}