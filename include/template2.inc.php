<?php
/*

	This file is part of beContent.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with beContent.  If not, see <http://www.gnu.org/licenses/>.

    http://www.becontent.org

    */
DEFINE("SQUARE", 1);
DEFINE("CURL", 2);
DEFINE('DEBUG', "DEBUG");
class Template
{
    var $template_file, $buffer, $foreach, $content, $pars, $parsed, $foreach_counter, $cache, $tags, $escaped_tags, $javascript;

    function Template ($filename = "")
    {
        if (file_exists($filename))
            {
                $this->template_file = $filename;
            }
        else
            {
                if (count($GLOBALS['config']['languages']) > 0)
                    {
                        $new_filename = substr($filename, 0, strpos($filename, "dtml"));
                        $new_filename .= "dtml/" . $GLOBALS['config']['currentlanguage'];
                        $new_filename .= substr($filename, strpos($filename, "dtml") + 4);
                        $filename = $new_filename;
                        $this->template_file = $filename;
                    }
            }
        $this->foreach = new ForeachCode();
        $result = preg_match("~\/?([^<>\/]+)\z~Us", $filename, $token);
        if ($result)
            $this->template_file = $token[1];
        $this->cache = new Cache($this->template_file);
        $this->parsed = FALSE;
        $this->foreach_counter = 1;
        if ($filename != "")
            {
                if (file_exists($filename))
                    {
                        $fp = fopen($filename, "r");
                        $this->buffer = fread($fp, filesize($filename));
                        fclose($fp);
                    }
                else
                    {
                        $this->buffer = $filename;
                    }
            }
        $i = 0;
        $this->setTagStyle(SQUARE);
    }

    function setTagStyle ($style)
    {
        switch ($style)
        {
            case CURL:
                $this->tags['open'] = "{";
                $this->tags['close'] = "}";
                $this->escaped_tags['open'] = "{";
                $this->escaped_tags['close'] = "}";
                break;
            case SQUARE:
            default:
                $this->tags['open'] = "<[";
                $this->tags['close'] = "]>";
                $this->escaped_tags['open'] = "<\[";
                $this->escaped_tags['close'] = "\]>";
                break;
        }
    }

    function setTemplate ($content)
    {
        $this->buffer = $content;
    }

    ////////////////////////////////////////////////////////////////*KAISERSOSE*/////////////////////////////////////////////////////////////////////////////////////////
    function checkPlaceholders ($buffer)
    {
        $temp_buffer = $buffer;
        $root = preg_replace("~<\[foreach\]>.*<\[\/foreach\]>~Us", "", $temp_buffer, - 1);
        do
            {
                $result1 = preg_match("~<\[foreach\]>(.*)<\[\/foreach\]>~Us", $temp_buffer, $token);
                if ($result1)
                    {
                        $temp_buffer = preg_replace("~<\[foreach\]>.*<\[\/foreach\]>~Us", "", $temp_buffer, 1);
                        $result2 = preg_match_all("~<\[(?!foreach|\/foreach)(.+)(::(.*))?\]>~Us", $token[1], $token2, PREG_PATTERN_ORDER);
                        if ($result2)
                            {
                                foreach ($token2[1] as $name)
                                    {
                                        $result3 = preg_match("~<\[foreach\]>(.*){$this->escaped_tags['open']}$name(::(.*))?{$this->escaped_tags['close']}(.*)<\[\/foreach\]>~Us", $temp_buffer, $token3);
                                        if ($result3)
                                            {
                                                trigger_error("cannot define variables with the same name in different foreach construct: (<[$name]>)", E_USER_ERROR);
                                            }
                                        $result4 = preg_match("~{$this->escaped_tags['open']}$name(::(.*))?{$this->escaped_tags['close']}~Us", $root, $token4);
                                        if ($result4)
                                            {
                                                trigger_error("cannot define variables with the same name in foreach construct and out of them: (<[$name]>)", E_USER_ERROR);
                                            }
                                    }
                            }
                    }
            }
        while ($result1);
    }

    function checkForeachConstructs ($buffer)
    {
        $temp_buffer = $buffer;
        $counter_foreach_opened = 0;
        $counter_foreach_closed = 0;
        do
            {
                $result = preg_match("~(<\[foreach\]>)|(<\[\/foreach\]>)~Us", $temp_buffer, $token);
                if ($result)
                    {
                        if ($token[1] == "<[foreach]>")
                            $counter_foreach_opened ++;
                        else
                            $counter_foreach_closed ++;
                        $temp_buffer = preg_replace("~<\[foreach\]>|<\[\/foreach\]>~Us", "", $temp_buffer, 1);
                    }
                if ($counter_foreach_opened < $counter_foreach_closed)
                    {
                        $diff = $counter_foreach_closed - $counter_foreach_opened;
                        trigger_error("cannot define <i><[/foreach]></i> close tag without <i><[foreach]></i> open tag", E_USER_ERROR);
                    }
            }
        while ($result);
        if ($counter_foreach_opened > $counter_foreach_closed)
            {
                $diff = $counter_foreach_opened - $counter_foreach_closed;
                trigger_error("cannot define <i><[foreach]></i> open tag without <i><[/foreach]></i> close tag", E_USER_ERROR);
            }
    }

    function checkTagLibraries ($buffer)
    {
        $temp_buffer = $buffer;
        do
            {
                $result = preg_match("~{$this->escaped_tags['open']}(.+)(::(.*)){$this->escaped_tags['close']}~U", $temp_buffer, $token);
                if ($result and (count($token) > 1))
                    {
                        if ($token[3] == "")
                            {
                                trigger_error("undefined selector of tagLibrary for <i><[$token[1]]></i> variable", E_USER_ERROR);
                            }
                        else
                            {
                                $result2 = preg_match("~\A::\S+~Us", $token[2]);
                                if (! $result2)
                                    {
                                        trigger_error("undefined selector of tagLibrary for <i><[$token[1]]></i> variable", E_USER_ERROR);
                                    }
                                $result3 = preg_match("~\A::(?!library)~Us", $token[2]);
                                if (! $result3)
                                    {
                                        trigger_error("cannot use string <i>library</i> as a selector for <i><[$token[1]]></i> variable", E_USER_ERROR);
                                    }
                                $result3 = preg_match("~(\"+|\s+)library\s*=\s*\"?\S*\"?~Us", $token[2]);
                                if (! $result3)
                                    {
                                        trigger_error("undefined tagLibrary for <i><[$token[1]]></i> variable", E_USER_WARNING);
                                    }
                            }
                    }
                $temp_buffer = preg_replace("~{$this->escaped_tags['open']}.+(::.+)?{$this->escaped_tags['close']}~Us", $temp_buffer, "", 1);
            }
        while ($result);
    }

    function setContent ($name, $value, $pars = "")
    {
        if ($name == "javascript")
            {
                #echo "setcontent javascript ($name - $value - $pars)<br>";
            }
        if (gettype($name) != "string")
            {
                trigger_error('$name cannot be a ' . gettype($name) . ' must be a string', E_USER_WARNING);
            }
        $this->content[0][] = $name;
        $this->content[1][] = $value;
        $this->content[2] = $pars;
    }

    function setContentOnce ($name, $value, $pars = "")
    {
        $trovato = false;
        foreach ($this->content[0] as $k => $v)
            {
                if ($v == $name)
                    {
                        $trovato = true;
                        $index = $k;
                    }
            }
        if (! $trovato)
            {
                $this->setContent($name, $value, $pars);
            }
    }

    function addentContent ($name, $value, $pars = "")
    {
        if (gettype($name) != "string")
            {
                trigger_error('$name cannot be a ' . gettype($name) . ' must be a string', E_USER_WARNING);
            }
        $trovato = false;
        foreach ($this->content[0] as $k => $v)
            {
                if ($v == $name)
                    {
                        $trovato = true;
                        $index = $k;
                    }
            }
        if ($trovato)
            {
                $this->content[1][$index] .= $value;
                $this->content[2] .= $pars;
            }
        else
            {
                #$this->content[0][]=$name;
                #$this->content[1][]=$value;
                #$this->content[2] = $pars;
                $this->setContent($name, $value, $pars);
            }
    }

    function loadContent ($content)
    {
        $contentKeys = $content[0];
        $contentValue = $content[1];
        $finalContent = array();
        for ($i = 0; $i < count($contentKeys); $i ++)
            {
                $placeholderName = $contentKeys[$i];
                $placeholderValue = $contentValue[$i];
                if ($foreachCode = $this->foreach->getForeachCode($this->foreach->getForeachName($placeholderName)))
                    { // Se è un contenuto iterato
                        $parsedContent = $this->transformContent($contentKeys[$i], $contentValue[$i], $foreachCode);
                        if (is_array($parsedContent))
                            {
                                foreach ($parsedContent as $currentParsedContentName => $currentParsedContentValue)
                                    {
                                        $finalContent[0][] = $currentParsedContentName;
                                        $finalContent[1][] = $currentParsedContentValue;
                                    }
                            }
                    }
                else
                    { // Se non è un contenuto iterato
                        $parsedContent = $this->transformContent($contentKeys[$i], $contentValue[$i], $this->buffer);
                        if (is_array($parsedContent))
                            {
                                foreach ($parsedContent as $currentParsedContentName => $currentParsedContentValue)
                                    {
                                        $finalContent[0][] = $currentParsedContentName;
                                        $finalContent[1][] = $currentParsedContentValue;
                                    }
                            }
                    }
            }
        return $finalContent;
    }

    function loadEmptyContent ($buffer)
    {
        $finalContent = NULL;
        $result = preg_match_all("~<\[(?!foreach\d+_\d+|\/foreach\d+_\d+)(.+)\]>~Us", $buffer, $token, PREG_SET_ORDER);
        if ($result)
            {
                foreach ($token as $placeholder)
                    {
                        $result = preg_match("~([^:]+)~", $placeholder[1], $token2);
                        if ($result)
                            {
                                $placeholderName = $token2[1];
                                $parsedContent = $this->transformContent($placeholderName, NULL, $buffer);
                                if (is_array($parsedContent))
                                    {
                                        foreach ($parsedContent as $currentParsedContentName => $currentParsedContentValue)
                                            {
                                                $finalContent[0][] = $currentParsedContentName;
                                                $finalContent[1][] = $currentParsedContentValue;
                                            }
                                    }
                            }
                    }
                for ($i = 0; $i < count($finalContent[0]); $i ++)
                    {
                        $currentParsedContentName = $finalContent[0][$i];
                        $currentParsedContentValue = $finalContent[1][$i];
                        $buffer = preg_replace("~{$this->escaped_tags['open']}$currentParsedContentName{$this->escaped_tags['close']}~Us", $currentParsedContentValue, $buffer, 1);
                    }
            }
        return $buffer;
    }

    function transformContent ($name, $data, $buffer)
    { //Interpretazione, e codifica di placeholder complessi
        $value = null;
        $library_obj = null;
        $tokensA = array();
        $tokensB = array();
        $paramTokens = array();
        $parameters = array();
        $simple_pattern = '~<\[(' . $name . ')\]>~Us';
        $complex_pattern = '~<\[((' . $name . ')::(\w+))\]>~Us';
        $complex_pattern_param = '~<\[((' . $name . ')::(\w+)\s+([^\]]+))\]>~Us';
        #complex_pattern_param
        preg_match_all($complex_pattern_param, $buffer, $tokensA, PREG_SET_ORDER);
        preg_match_all($complex_pattern, $buffer, $tokensB, PREG_SET_ORDER);
        $tokens = array_merge($tokensA, $tokensB);
        if (! empty($tokens))
            {
                foreach ($tokens as $token)
                    {
                        unset($library);
                        $selector = $token[3];
                        $result = preg_match_all('~(\w+)=\"?([^\"]+)\"?~s', $token[4], $paramTokens, PREG_SET_ORDER);
                        if ($result) //Parameters parsing
                            {
                                foreach ($paramTokens as $paramToken)
                                    {
                                        if (strcmp($paramToken[1], 'library') == 0)
                                            {
                                                if (! file_exists("include/tags/{$paramToken[2]}.inc.php"))
                                                    trigger_error("Library <b>$library</b> does not exists!", E_USER_ERROR);
                                                else
                                                    $library = $paramToken[2];
                                            }
                                        else
                                            $parameters[$paramToken[1]] = $paramToken[2];
                                    }
                            }
                        include_once ("include/tags/$library.inc.php");
                        eval("\$library_obj = new \$library();");
                        if (! (method_exists($library_obj, $selector)))
                            trigger_error("selector <b>$selector</b> does not exist in library <b>$library</b>", E_USER_ERROR);
                        $value[$token[1]] = $library_obj->apply($name, $data, $parameters, $selector);
                    }
            }
            #simple_pattern
        $result = preg_match_all($simple_pattern, $buffer, $tokens, PREG_SET_ORDER);
        if ($result)
            {   
                foreach ($tokens as $token)
                    $value[$token[1]] = $data;
            }
        return $value;
    }

    function string_to_pattern ($pattern)
    {
        $escape_array = Array('\"' , '\.');
        foreach ($escape_array as $char)
            {
                $pattern = preg_replace("~$char~", $char, $pattern, - 1);
            }
        return $pattern;
    }

    function parse ()
    {
        if ($this->template_file == "frame-public.html")
            {
                if (isset($_REQUEST['mode']) && (($_REQUEST['mode'] == "ajax") or ($_REQUEST['mode'] == "compact")))
                    {
                        foreach ($this->content[0] as $index => $name)
                            {
                                if ($name == "body")
                                    {
                                        $position = $index;
                                    }
                            }
                        $this->buffer = $this->content[1][$position];
                    }
                else
                    {
                        $this->common();
                    }
            }
            #$this->setContent("script", basename($_SERVER['SCRIPT_NAME']));
        $this->setContent("server", (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : '');
        $this->setContent("skin", (isset($GLOBALS['config']['skin'])) ? $GLOBALS['config']['skin'] : '');
        $this->setContent("base", (isset($GLOBALS['config']['base'])) ? $GLOBALS['config']['base'] : '');
        $this->setContent("user.username", (isset($_SESSION['user']['username'])) ? $_SESSION['user']['username'] : '');
        $this->setContent("user.name", (isset($_SESSION['user']['name'])) ? $_SESSION['user']['name'] : '');
        $this->setContent("user.surname", (isset($_SESSION['user']['surname'])) ? $_SESSION['user']['surname'] : '');
        $this->setContent("user.lastlogin", (isset($_SESSION['user']['lastlogin'])) ? $_SESSION['user']['lastlogin'] : '');
        $this->setContent("email", (isset($_SESSION['user']['email'])) ? $_SESSION['user']['email'] : '');
        if ($this->cache->caching == TRUE)
            {
                if ($this->cache->cacheFileExists())
                    {
                        if ($this->cache->checkCacheFile())
                            {
                                $this->buffer = $this->cache->getCacheFileContent();
                            }
                        else
                            {
                                $this->checkPlaceholders($this->buffer);
                                $this->checkForeachConstructs($this->buffer);
                                $this->checkTagLibraries($this->buffer);
                                $this->buffer = $this->foreach->parseForeach($this->buffer);
                                $this->content = $this->loadContent($this->content);
                                $this->buffer = $this->foreach->bindAll($this->content, $this->buffer);
                                $this->buffer = $this->loadEmptyContent($this->buffer);
                                $this->buffer = $this->cache->buildCacheFile($this->buffer, $this->template_file);
                            }
                    }
                else
                    {
                        $this->checkPlaceholders($this->buffer);
                        $this->checkForeachConstructs($this->buffer);
                        $this->checkTagLibraries($this->buffer);
                        $this->buffer = $this->foreach->parseForeach($this->buffer);
                        $this->content = $this->loadContent($this->content);
                        $this->buffer = $this->foreach->bindAll($this->content, $this->buffer);
                        $this->buffer = $this->loadEmptyContent($this->buffer);
                        $this->buffer = $this->cache->buildCacheFile($this->buffer, $this->template_file);
                    }
            }
        else
            {
                /* The following are used for checking Errors! */
                $this->checkPlaceholders($this->buffer);
                $this->checkForeachConstructs($this->buffer);
                $this->checkTagLibraries($this->buffer);
                $this->buffer = $this->foreach->parseForeach($this->buffer);
                $this->content = $this->loadContent($this->content);
                $this->buffer = $this->foreach->bindAll($this->content, $this->buffer);
                $this->buffer = $this->loadEmptyContent($this->buffer);
            }
        $this->parsed = true;
    }

    /* ALFONSO ON */
    function getExtension ()
    {
        $extension = "\n<!-- being generated inclusions -->\n";
        $files = array();
        foreach (get_declared_classes() as $k => $v)
            {
                if (strtolower(get_parent_class($v)) == "taglibrary")
                    {
                        $methods = get_class_methods($v); //print_r($methods);
                        if (version_compare(phpversion(), "5.0", "<"))
                            {
                                $method = "includejs";
                            }
                        else
                            {
                                $method = "includeJS";
                            }
                        if (in_array($method, $methods))
                            {
                                eval("\$files[] = " . $v . "::includeJS();");
                            }
                    }
            }
        for ($i = 0; $i < count($files); $i ++)
            {
                $extension .= "<script type=\"text/javascript\" src=\"{$files[$i]}\"></script>\n";
            }
        $files = array();
        foreach (get_declared_classes() as $k => $v)
            {
                if (strtolower(get_parent_class($v)) == "taglibrary")
                    {
                        $methods = get_class_methods($v); //print_r($methods);
                        if (version_compare(phpversion(), "5.0", "<"))
                            {
                                $method = "includestyle";
                            }
                        else
                            {
                                $method = "includeStyle";
                            }
                        if (in_array($method, $methods))
                            {
                                eval("\$files[] = " . $v . "::includeStyle();");
                            }
                    }
            }
        for ($i = 0; $i < count($files); $i ++)
            {
                $extension .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{files[$i]}\" />\n";
            }
        $local_buffer = "";
        foreach (get_declared_classes() as $k => $v)
            {
                if (strtolower(get_parent_class($v)) == "taglibrary")
                    {
                        $methods = get_class_methods($v); //print_r($methods);
                        if (version_compare(phpversion(), "5.0", "<"))
                            {
                                $method = "injectjs";
                            }
                        else
                            {
                                $method = "injectJS";
                            }
                        if (in_array($method, $methods))
                            {
                                eval("\$local_buffer .= " . $v . "::injectJS();");
                                if ($local_buffer != "")
                                    {
                                        $local_buffer .= "\n\n";
                                    }
                            }
                    }
            }
        if ($local_buffer != "")
            {
                $extension .= "<script>\n{$local_buffer}";
                $extension .= "</script>\n";
            }
        $local_buffer = "";
        foreach (get_declared_classes() as $k => $v)
            {
                if (strtolower(get_parent_class($v)) == "taglibrary")
                    {
                        $methods = get_class_methods($v); //print_r($methods);
                        if (version_compare(phpversion(), "5.0", "<"))
                            {
                                $method = "injectstyle";
                            }
                        else
                            {
                                $method = "injectStyle";
                            }
                        if (in_array($method, $methods))
                            {
                                eval("\$local_buffer .= " . $v . "::injectStyle();");
                                if ($local_buffer != "")
                                    {
                                        $local_buffer .= "\n\n";
                                    }
                            }
                    }
            }
        if ($local_buffer != "")
            {
                $extension .= "<style type=\"text/css\">\n{$local_buffer}";
                $extension .= "</style> <!-- end generated inclusions -->\n";
            }
        return $extension;
    }

    /* ALFONSO OFF */
    function display ($buffer)
    {
        echo $buffer;
    }

    function get ()
    {
        if (! $this->parsed)
            {
                $this->parse();
            }
        $this->buffer = preg_replace("~<\[(?!foreach\d+_\d+|\/foreach\d+_\d+).+\]>~Us", "", $this->buffer, - 1);
        $this->buffer = preg_replace("~<\[foreach\d+_\d+\]>~Us", "", $this->buffer, - 1);
        $this->buffer = preg_replace("~<\[\/foreach\d+_\d+\]>~Us", "", $this->buffer, - 1);
        return $this->buffer;
    }

    function close ()
    {
        $this->setContent("style", $this->getExtension());
        if (! $this->parsed)
            {
                $this->parse();
            }
        $this->buffer = preg_replace("~<\[(?!foreach\d+_\d+|\/foreach\d+_\d+).+\]>~Us", "", $this->buffer, - 1);
        $pos = strpos($this->buffer, "</head>");
        $result = $this->buffer;
        if ($pos != false)
            {
                $pre = substr($this->buffer, 0, $pos);
                $post = substr($this->buffer, $pos + 7);
                $result = $pre . $this->getExtension() . "</head>\n" . $post;
                $this->buffer = $result;
            }
        $this->display($result);
    }

    function setCacheLifeTime ($lifetime)
    {
        $this->cache->setCacheLifetime($lifetime);
    }

    function caching ($flag)
    {
        $this->cache->caching($flag);
    }

    function common ()
    {
        if (function_exists("shared"))
            {
                shared();
            }
    }
}
class Cache
{
    var $caching, $cache_dir, $cache_file, $cache_file_lifetime;

    function Cache ($template_file)
    {
        $this->cache_dir = $this->setDefaultCacheDir();
        $this->caching = FALSE;
        $this->cache_file_lifetime = 60;
        $this->template_file_name = $template_file;
        $this->cache_file = $this->setDefaultCacheFile();
    }

    function setDefaultCacheFile ()
    {
        $cache_dir = "cache";
        $cache_file = $cache_dir . "/" . $this->template_file_name . "_temp.php";
        return $cache_file;
    }

    function setDefaultCacheDir ()
    {
        $cache_dir = "cache";
        return $cache_dir;
    }

    function caching ($flag)
    {
        if (gettype($flag) == "boolean")
            $this->caching = $flag;
        else
            trigger_error('$flag cannot be a ' . gettype($flag) . ' must be a boolean', E_USER_WARNING);
        if (! $flag)
            {
                if ($this->cacheFileExists())
                    {
                        if (PHP_OS == "WINNT" or PHP_OS == "WIN32")
                            {
                                $temp_dir = $this->getDefaultCacheDirName();
                                $temp_file = $this->getDefaultCacheFileName();
                                exec("del $temp_dir\\$temp_file", $output, $result);
                                if ($result != 0)
                                    {
                                        trigger_error("cannot remove <i>$this->cache_file</i> cache file", E_USER_WARNING);
                                    }
                            }
                        else
                            {
                                exec("del $this->cache_file", $output, $result);
                                if ($result != 0)
                                    {
                                        trigger_error("cannot remove <i>$this->cache_file</i> cache file", E_USER_WARNING);
                                    }
                            }
                        exec("rmdir $this->cache_dir", $output, $result);
                        if ($result != 0)
                            {
                                trigger_error("cannot remove <i>$this->cache_dir</i> directory", E_USER_WARNING);
                            }
                    }
            }
        else
            {
                exec("mkdir $this->cache_dir", $output, $result);
                if ($result != 0 and ! $this->cacheFileExists())
                    {
                        trigger_error("cannot create <i>$this->cache_dir</i> directory", E_USER_WARNING);
                    }
            }
    }

    function buildCacheFile ($buffer, $template_file)
    {
        $cfile = fopen($this->cache_file, "w");
        $info_cache_file = fstat($cfile);
        $buffer = "<!-- This page has been generated the first time on " . date("d/m/Y", $info_cache_file[10]) . " at " . date("H:i:s", $info_cache_file[10]) . ". Last generation on " . date("d/m/Y", $info_cache_file[9]) . " at " . date("H:i:s", $info_cache_file[9]) . " -->" . $buffer;
        fwrite($cfile, $buffer);
        fclose($cfile);
        return $buffer;
    }

    function getCacheFileContent ()
    {
        $cfile = fopen($this->cache_file, "r");
        $buffer = fread($cfile, filesize($this->cache_file));
        fclose($cfile);
        return $buffer;
    }

    function cacheFileExists ()
    {
        return file_exists($this->cache_file);
    }

    function checkCacheFile ()
    {
        $cfile = fopen($this->cache_file, "r");
        $info_cache_file = fstat($cfile);
        $lifetime = (time()) - ($info_cache_file[9]);
        if ($this->cache_file_lifetime < $lifetime)
            {
                fclose($cfile);
                return FALSE;
            }
        else
            {
                fclose($cfile);
                return TRUE;
            }
    }

    function setCacheLifetime ($lifetime)
    {
        if (gettype($lifetime) == "integer")
            $this->cache_file_lifetime = $lifetime;
        else
            trigger_error('$lifetime cannot be a ' . gettype($lifetime) . ' must be an integer', E_USER_WARNING);
    }

    function setCacheDir ($dir)
    {
        if (gettype($dir) == "string")
            $this->cache_dir = $dir;
        else
            trigger_error('$dir cannot be a ' . gettype($dir) . ' must be a string', E_USER_WARNING);
    }

    function getDefaultCacheDirName ()
    {
        return $this->cache_dir;
    }

    function getDefaultCacheFileName ()
    {
        $result = preg_match("~\/(.+)~", $this->cache_file, $token);
        return $token[1];
    }
}
class TagLibrary
{

    function apply ($name, $data, $pars, $selector)
    {
        $result = call_user_func(array($this , $selector), $name, $data, $pars);
        return $result;
    }
}
class ForeachCode
{
    var $foreachCodeArray, $placeholderArray, $foreachHierarchyArray, $deep;

    function ForeachCode ()
    {
        $this->deep = 0;
        $this->foreachCounter = 0;
    }

    function parseForeach ($buffer)
    {
        $buffer = $this->getForeachEnumeration($buffer);
        $result = preg_match_all("~<\[(foreach(\d+)_(\d+))\]>(.+)<\[\/foreach\\2_\\3\]>~Us", $buffer, $token, PREG_SET_ORDER);
        if ($result)
            {
                foreach ($token as $currentForeach)
                    {
                        $this->fillForeachArray($currentForeach[1], $currentForeach[4]); //Alimento gli array per il binding dei contenuti
                        $buffer = preg_replace("~<\[$currentForeach[1]\]>.+<\[\/$currentForeach[1]\]>~Us", "<[$currentForeach[1]]><!--FOREACH CODE--><[/$currentForeach[1]]>", $buffer, - 1);
                    }
            }
        return $buffer;
    }

    function getForeachEnumeration ($buffer)
    {
        $deep = - 1;
        $ID = 0;
        $IDarray[0] = 1;
        $result = preg_match("~<\[\/?foreach\]>~Us", $buffer, $foreachOpenTag);
        while ($result)
            {
                if ($foreachOpenTag[0] == "<[foreach]>")
                    {
                        $deep ++;
                        $ID ++;
                        array_push($IDarray, $ID);
                        $buffer = preg_replace("~<\[foreach\]>~Us", "<[foreach" . $deep . "_" . $ID . "]>", $buffer, 1);
                    }
                else if ($foreachOpenTag[0] == "<[/foreach]>")
                    {
                        $lastForeachID = array_pop($IDarray);
                        $buffer = preg_replace("~<\[\/foreach\]>~Us", "<[/foreach" . $deep . "_" . $lastForeachID . "]>", $buffer, 1);
                        $deep = $deep - 1;
                    }
                $result = preg_match("~<\[\/?foreach\]>~Us", $buffer, $foreachOpenTag);
            }
        return $buffer;
    }

    function fillForeachArray ($foreachName, $foreachCode)
    {
        //Pulisco il codice del foreach eliminando quello dei foreach annidati in modo da considerare solo i placeholder a questo livello
        $result = preg_match_all("~<\[(foreach(\d+)_(\d+))\]>.+<\[\/foreach\\2_\\3\]>~Us", $foreachCode, $token2, PREG_SET_ORDER);
        if ($result)
            { //currentForeachChild[1] = foreachChildName
                foreach ($token2 as $currentForeachChild)
                    {
                        $foreachChildName = $currentForeachChild[1];
                        $foreachCleanedCode = preg_replace("~<\[$foreachChildName\]>.+<\[\/$foreachChildName\]>~Us", "<[$foreachChildName]>FOREACH_CODE<[/$foreachChildName]>", $foreachCode, 1);
                    }
                    //Alimento array dei foreach con il foreach corrente
                $this->foreachCodeArray[$foreachName] = $foreachCleanedCode;
            }
        else
            { // Se non ci sono foreach annidati non serve pulire il codice
                $foreachCleanedCode = $foreachCode; // Mi serve per cercare solo i placeholdea questo livello nel prossimo if
                $this->foreachCodeArray[$foreachName] = $foreachCode;
            }
            //Alimento array dei placeholder nel foreach
        $result = preg_match_all("~<\[(?!foreach\d+_\d+|\/foreach\d+_\d+)(.+)\]>~Us", $foreachCleanedCode, $token, PREG_SET_ORDER);
        if ($result)
            { //currentPlaceholder[1] = placeholderName
                foreach ($token as $currentPlaceholder)
                    {
                        $placeholderName = $currentPlaceholder[1];
                        $this->setForeachPlaceholder($foreachName, $placeholderName);
                    }
            } // Fine alimentazione array dei placeholder nel foreach
        //Alimento array dei nomi dei foreach annidati nel foreach corrente e invoco questa funzione ricorsiva per i foreach figli
        $result = preg_match_all("~<\[(foreach(\d+)_(\d+))\]>(.+)<\[\/foreach\\2_\\3\]>~Us", $foreachCode, $token2, PREG_SET_ORDER);
        if ($result)
            { //currentForeachChild[1] = foreachChildName
                foreach ($token2 as $currentForeachChild)
                    {
                        $foreachChildName = $currentForeachChild[1];
                        $foreachChildCode = $currentForeachChild[4];
                        //Ricorsione
                        $this->foreachHierarchyArray[$foreachName][] = $foreachChildName;
                        $this->fillForeachArray($foreachChildName, $foreachChildCode);
                    }
            } // Fine
    }

    function bindAll ($content, $buffer)
    {
        if ($content)
            {
                $contentKeys = $content[0];
                $contentValue = $content[1];
            }
        else
            {
                return $buffer;
            }
        for ($i = 0; $i < count($contentValue); $i ++)
            { // Istanzio i placeholder non iterati
                $currentContentValue = $contentValue[$i];
                $currentContentName = $contentKeys[$i];
                $buffer = $this->setSimplePlaceholderValue($currentContentName, $currentContentValue, $buffer);
            }
        $result = preg_match_all("~<\[(foreach\d+_\d+)\]>.+<\[\/\\1\]>~Us", $buffer, $token, PREG_SET_ORDER);
        if ($result)
            {
                foreach ($token as $currentForeachName)
                    { //Istanzio i contenuti dei foreach
                        $temp_content = $content; //Evito di eliminare tutti i contenuti con il primo foreach
                        $currentForeachCode = $this->getForeachCode($currentForeachName[1]);
                        $currentForeachChilds = $this->getForeachChilds($currentForeachName[1]);
                        $currentForeachPlaceholders = $this->getForeachPlaceholders($currentForeachName[1]);
                        $buffer = $this->setForeachBindedCode($currentForeachName[1], $buffer, $this->bindForeach($currentForeachName[1], $currentForeachCode, $currentForeachPlaceholders, $currentForeachChilds, $temp_content));
                    }
            }
        return $buffer;
    }

    function bindForeach ($foreachName, $foreachCode, $foreachPlaceholders, $foreachChilds, &$content)
    {
        reset($content);
        if ($content[0])
            { //Ci sono contenuti in content
                if ($foreachChilds)
                    { //Il foreach ha annidamenti
                        $currentContentName = reset($content[0]);
                        $currentContentValue = reset($content[1]);
                        do
                            {
                                if ($this->isForeachPlaceholder($currentContentName))
                                    { //E' un contenuto da iterare
                                        if ($this->isTherePlaceholder($currentContentName, $foreachName))
                                            { //E' un contenuto per questo foreach
                                                $foreachCode = $this->setPlaceholderValue($currentContentName, $currentContentValue, $foreachName, $foreachCode); //inserisco
                                                array_shift($content[0]);
                                                array_shift($content[1]);
                                                $currentContentName = reset($content[0]);
                                                $currentContentValue = reset($content[1]);
                                            }
                                        else
                                            { //Non è un contenuto per questo foreach
                                                if ($this->isRelativeForeachPlaceholder($currentContentName, $foreachName))
                                                    {
                                                        //E' un placeholder di un foreach figlio o discendente
                                                        if ($this->isDescendantForeachPlaceholder($currentContentName, $foreachName))
                                                            {
                                                                //Invoco ricorsivamente la funzione per il foreach figlio da cui discende l'elemento
                                                                $child = $this->getChildFromDescendantPlaceholder($currentContentName, $foreachName);
                                                                $foreachCode = $this->setForeachBindedCode($child, $foreachCode, $this->bindForeach($child, $this->getForeachCode($child), $this->getForeachPlaceholders($child), $this->getForeachChilds($child), $content));
                                                                if ($content[0])
                                                                    {
                                                                        $currentContentName = reset($content[0]);
                                                                        $currentContentValue = reset($content[1]);
                                                                    }
                                                            }
                                                        else if ($this->isBrotherForeachPlaceholder($currentContentName, $foreachName))
                                                            {
                                                                return $foreachCode;
                                                            }
                                                        else
                                                            {
                                                                return $foreachCode;
                                                            }
                                                    }
                                                else
                                                    {
                                                        array_shift($content[0]);
                                                        array_shift($content[1]);
                                                        if ($content[0])
                                                            {
                                                                $currentContentName = reset($content[0]);
                                                                $currentContentValue = reset($content[1]);
                                                            }
                                                    }
                                            }
                                    }
                                else
                                    { //Non è un contenuto da iterare, vado avanti
                                        array_shift($content[0]);
                                        array_shift($content[1]);
                                        if ($content[0])
                                            {
                                                $currentContentName = reset($content[0]);
                                                $currentContentValue = reset($content[1]);
                                            }
                                    }
                            }
                        while ($content[0]);
                        return $foreachCode;
                    }
                else
                    { // Il foreach non ha annidamenti
                        $currentContentName = reset($content[0]);
                        $currentContentValue = reset($content[1]);
                        do
                            {
                                if ($this->isForeachPlaceholder($currentContentName))
                                    { //E' un contenuto da iterare
                                        if ($this->isTherePlaceholder($currentContentName, $foreachName))
                                            { //E' un contenuto per questo foreach
                                                $foreachCode = $this->setPlaceholderValue($currentContentName, $currentContentValue, $foreachName, $foreachCode); //inserisco
                                                array_shift($content[0]);
                                                array_shift($content[1]);
                                                $currentContentName = reset($content[0]);
                                                $currentContentValue = reset($content[1]);
                                            }
                                        else
                                            { //Non è un contenuto per questo foreach
                                                if ($this->isRelativeForeachPlaceholder($currentContentName, $foreachName))
                                                    {
                                                        if ($this->isBrotherForeachPlaceholder($currentContentName, $foreachName))
                                                            {
                                                                return $foreachCode;
                                                            }
                                                        else
                                                            {
                                                                return $foreachCode;
                                                            }
                                                    }
                                                else
                                                    { //Se questo contenuto non appartiene a questa iterazione vado avanti
                                                        array_shift($content[0]);
                                                        array_shift($content[1]);
                                                        if ($content[0])
                                                            {
                                                                $currentContentName = reset($content[0]);
                                                                $currentContentValue = reset($content[1]);
                                                            }
                                                    }
                                            }
                                    }
                                else
                                    { //Non è un contenuto da iterare, vado avanti
                                        array_shift($content[0]);
                                        array_shift($content[1]);
                                        if ($content[0])
                                            {
                                                $currentContentName = reset($content[0]);
                                                $currentContentValue = reset($content[1]);
                                            }
                                    }
                            }
                        while ($content[0]);
                        return $foreachCode;
                    }
            }
        return $foreachCode;
    }

    function getForeachDeep ($foreachName)
    {
        $result = preg_match("~foreach(\d+)_(\d+)~Us", $foreachName, $infoPlaceholderName);
        if ($result)
            {
                return $infoPlaceholderName[1];
            }
        return NULL;
    }

    function getForeachID ($foreachName)
    {
        $result = preg_match("~foreach(\d+)_(\d+)~Us", $foreachName, $infoPlaceholderName);
        if ($result)
            {
                return $infoPlaceholderName[2];
            }
        return NULL;
    }

    function getForeachChilds ($foreachName)
    {
        if (! $this->foreachHierarchyArray)
            return NULL;
        foreach (array_keys($this->foreachHierarchyArray) as $foreachParent)
            {
                if ($foreachName == $foreachParent)
                    return $this->foreachHierarchyArray[$foreachName];
            }
        return NULL;
    }

    function getForeachPlaceholders ($foreachName)
    {
        return $this->placeholderArray[$foreachName];
    }

    function getForeachCode ($foreachName)
    {
        if ($foreachName)
            {
                return $this->foreachCodeArray[$foreachName];
            }
        else
            return NULL;
    }

    function getForeachName ($placeholderName)
    {
        if (is_array($this->placeholderArray))
            {
                foreach ($this->placeholderArray as $currentForeachName => $currentPlaceholderSet)
                    { //Cerco il foreach corrispondente a questo Placeholder
                        foreach ($currentPlaceholderSet as $currentPlaceholder)
                            {
                                $result = preg_match("~(.+)::(.+)~Us", $placeholderName, $token);
                                $result2 = preg_match("~(.+)::(.+)~Us", $currentPlaceholder, $token2);
                                if ($result && $result2)
                                    {
                                        if ($token[1] == $token2[1])
                                            {
                                                return $currentForeachName;
                                            }
                                    }
                                else if ($result2)
                                    {
                                        if ($token2[1] == $placeholderName)
                                            {
                                                return $currentForeachName;
                                            }
                                    }
                                else if ($result)
                                    {
                                        if ($token[1] == $currentPlaceholder)
                                            {
                                                return $currentForeachName;
                                            }
                                    }
                                else
                                    {
                                        if ($currentPlaceholder == $placeholderName)
                                            {
                                                return $currentForeachName;
                                            }
                                    }
                            }
                    }
            }
        return NULL;
    }

    function getChildFromDescendantPlaceholder ($placeholderName, $foreachName)
    { //Ritorna il nome del foreach figlio da cui discende l'elemento se esiste
        $check = FALSE;
        $foreachChilds = $this->getForeachChilds($foreachName);
        if ($foreachChilds)
            { // il foreach corrente NON è una foglia
                foreach ($foreachChilds as $child)
                    { //Se il prossimo foreach è un mio discendente
                        foreach ($this->getForeachPlaceholders($child) as $currentPlaceholder)
                            {
                                if ($placeholderName == $currentPlaceholder)
                                    return $child;
                            }
                        $check = $this->isDescendantForeachPlaceholder($placeholderName, $child);
                        if ($check)
                            return $child;
                    }
                return NULL;
            }
        else
            { //il foreach corrente è una foglia
                return NULL;
            }
    }

    function getRootForeach ($foreachName)
    {
        $deep = $this->getForeachDeep($foreachName);
        $ID = $this->getForeachID($foreachName);
        if ($deep == 0)
            return $foreachName;
        foreach ($this->foreachCodeArray as $currentForeachName => $currentForeachValue)
            {
                if ($this->getForeachDeep($currentForeachName) == 0 && $this->getForeachID($currentForeachName) < $ID)
                    {
                        $foreachRootArray[$this->getForeachID($currentForeachName)] = $currentForeachName;
                    }
            }
        $rootForeach = $foreachRootArray[max(array_keys($foreachRootArray))];
        return $rootForeach;
    }

    function isForeachPlaceholder ($placeholderName)
    {
        foreach ($this->placeholderArray as $currentForeachName => $currentPlaceholderSet)
            { //Cerco il foreach corrispondente a questo Placeholder
                foreach ($currentPlaceholderSet as $currentPlaceholder)
                    {
                        if ($placeholderName == $currentPlaceholder)
                            {
                                return TRUE;
                            }
                    }
            }
        return FALSE;
    }

    function isTherePlaceholder ($placeholderName, $foreachName)
    {
        $foreachPlaceholders = $this->getForeachPlaceholders($foreachName);
        foreach ($foreachPlaceholders as $currentPlaceholder)
            {
                if ($placeholderName == $currentPlaceholder)
                    {
                        return TRUE;
                    }
            }
        return FALSE;
    }

    function isRelativeForeachPlaceholder ($placeholderName, $foreachName)
    {
        $rootForeach = $this->getRootForeach($foreachName);
        foreach ($this->getForeachPlaceholders($rootForeach) as $rootPlaceholderName)
            {
                if ($rootPlaceholderName == $placeholderName)
                    {
                        return TRUE;
                    }
            }
        if ($this->isDescendantForeachPlaceholder($placeholderName, $rootForeach))
            {
                return TRUE;
            }
        else
            {
                return FALSE;
            }
    }

    function isDescendantForeachPlaceholder ($placeholderName, $foreachName)
    { //Controlla se esiste un discendente che contiene questo placeholder
        $check = FALSE;
        $foreachChilds = $this->getForeachChilds($foreachName);
        if ($foreachChilds)
            { // il foreach corrente NON è una foglia
                foreach ($foreachChilds as $child)
                    { //Se il prossimo foreach è un mio discendente
                        foreach ($this->getForeachPlaceholders($child) as $currentPlaceholder)
                            {
                                if ($placeholderName == $currentPlaceholder)
                                    return TRUE;
                            }
                        $check = $this->isDescendantForeachPlaceholder($placeholderName, $child);
                        if ($check)
                            return TRUE;
                    }
                return FALSE;
            }
        else
            { //il foreach corrente è una foglia
                return FALSE;
            }
    }

    function isBrotherForeachPlaceholder ($placeholderName, $foreachName)
    {
        $checkForeachName = $this->getForeachName($placeholderName);
        //se il prossimo foreach ha lo stesso genitore allora è al mio stesso livello
        foreach ($this->foreachHierarchyArray as $currentForeachName => $currentForeachChilds)
            {
                foreach ($currentForeachChilds as $child)
                    {
                        if ($child == $foreachName)
                            {
                                $foreachParent = $currentForeachName;
                                break;
                            }
                    }
            }
        foreach ($this->getForeachChilds($foreachParent) as $child)
            {
                if ($child == $checkForeachName)
                    return TRUE;
            }
        return FALSE;
    }

    function setPlaceholderValue ($placeholderName, $placeholderValue, $foreachName, $foreachCode)
    {
        $result = preg_match("~<\[$placeholderName\]>~Us", $foreachCode);
        if ($result)
            { //Se c'è il placeholder lo istanzio
                $foreachCode = preg_replace("~<\[$placeholderName\]>~Us", $placeholderValue, $foreachCode, - 1);
            }
        else
            { // Se non c'è controllo se si trova nel codice del foreach pulito, nel caso in cui lo appendo
                $foreachCode = preg_replace("~<\[(foreach\d+_\d+)\]>.+<\[\/\\1\]>~Us", "", $foreachCode, - 1); //Elimino i vecchi foreach annidati, sono in una nuova iterazione
                $result = preg_match("~<\[$placeholderName\]>~Us", $this->getForeachCode($foreachName));
                if ($result)
                    {
                        $foreachCode = $foreachCode . (preg_replace("~<\[$placeholderName\]>~Us", $placeholderValue, $this->getForeachCode($foreachName), - 1));
                    }
            }
        return $foreachCode;
    }

    function setSimplePlaceholderValue ($placeholderName, $placeholderValue, $buffer)
    {
        $result = preg_match("~<\[$placeholderName\]>~Us", $buffer);
        if ($result)
            {
                $buffer = preg_replace("~<\[$placeholderName\]>~Us", "" . $placeholderValue, $buffer, - 1);
            }
        return $buffer;
    }

    function setForeachBindedCode ($foreachName, $buffer, $code)
    {
        $result = preg_match("~<\[$foreachName\]>(.+)<\[\/$foreachName\]>~Us", $buffer, $token);
        if ($result)
            {
                $buffer = preg_replace("~<\[$foreachName\]>.+<\[\/$foreachName\]>~Us", $code, $buffer, 1);
            }
        return $buffer;
    }

    function setForeachPlaceholder ($foreachName, $placeholder)
    {
        $this->placeholderArray[$foreachName][] = $placeholder;
    }
}
class Skin extends Template
{
    var $name, $templates, $placeholders, $private, $cache, $cached, $cache_name, $timeout;

    function Skin ($skin = "")
    {
        if ($skin == "")
            {
                $skin = $GLOBALS['config']['skin'];
            }
        else
            {
                $GLOBALS['config']['skin'] = $skin;
            }
        $GLOBALS["current_skin"] = $skin;
        $this->name = $skin;
        if (class_exists("Auth"))
            {
                Template::Template("skins/{$skin}/dtml/frame-private.html");
                $this->private = true;
            }
        else
            {
                Template::Template("skins/{$skin}/dtml/frame-public.html");
                $this->private = false;
            }
        $this->cache_name = "{$GLOBALS['config']['cache_folder']}/" . md5(basename($_SERVER['SCRIPT_FILENAME']) . "?{$_SERVER['QUERY_STRING']}-{$GLOBALS['config']['currentlanguage']}-{$GLOBALS['config']['currenttab']}") . ".html";
        if ($this->regenerateCache())
            {
                $this->setContent("skin", $skin);
                $this->setContent("base", $GLOBALS['config']['base']);
                $this->setContent("server", $_SERVER['SERVER_NAME']);
            }
        else
            {
                $cache = new Template($this->cache_name);
                $cache->close();
                exit();
            }
    }

    function regenerateCache ()
    {
        if ((basename($_SERVER['SCRIPT_FILENAME']) != "error.php") and (! isset($_REQUEST['nocache'])))
            {
                if ($GLOBALS['config']['cache_mode'] == NONE)
                    {
                        $result = true;
                    }
                elseif ($this->private)
                    {
                        $result = true;
                    }
                else
                    {
                        $result = false;
                    }
                if (! $result)
                    {
                        if (! (file_exists($this->cache_name)) or (filemtime($this->cache_name) + $GLOBALS['config']['cache_timeout'] < time()))
                            {
                                $result = true;
                            }
                    }
            }
        else
            {
                $result = true;
            }
        return $result;
    }

    function addSkin ($placeholder, $template)
    {
        $this->templates[$template] = & new Template("skins/{$this->name}/dtml/{$template}.html");
        $this->placeholders[$template] = $placeholder;
    }

    function setSkinContent ($template, $name, $value)
    {
        #echo get_class($this->templates[$template])
        $this->templates[$template]->setContent($name, $value);
    }

    function close ()
    {
        if (is_array($this->templates))
            {
                foreach ($this->templates as $name => $template)
                    {
                        $this->setContent($this->placeholders[$name], $template->get());
                    }
            }
        if ($this->private)
            {
                #$this->addentContent("javascript", "<script language=\"javascript\" type=\"text/javascript\" src=\"js/tiny_mce/tiny_mce.js\"></script>\n");
                #$this->addentContent("javascript", "<script language=\"javascript\" type=\"text/javascript\" src=\"js/becontent.js\"></script>\n");
                if ($GLOBALS['config']['jquery'])
                    {
                        $this->addentContent("javascript", "<link type=\"text/css\" rel=\"stylesheet\" href=\"http://ui.jquery.com/testing/themes/base/ui.all.css\" />
\n");
                        $this->addentContent("javascript", "<script type=\"text/javascript\" src=\"js/jquery.js\"></script>\n");
                        $this->addentContent("javascript", "<script type=\"text/javascript\" src=\"js/jquery-ui-personalized-1.5.3.min.js\"></script>\n");
                        #$this->addentContent("javascript", "<script type=\"text/javascript\" src=\"js/jquery-ui-personalized-1.5.3.js\"></script>\n");
                    }
                $this->addentContent("head", "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen, print\" href=\"css/beContent.css\" />");
            }
        Template::close();
        if (! $this->private)
            {
                $buffer = $this->buffer;
                $fp = fopen($this->cache_name, "w");
                fwrite($fp, $buffer);
                fclose($fp);
            }
    }
}
class Skinlet extends Template
{

    function Skinlet ($template)
    {
        if (! strpos($template, "."))
            {
                Template::Template("skins/{$GLOBALS['current_skin']}/dtml/{$template}.html");
            }
        else
            {
                Template::Template("skins/{$GLOBALS['current_skin']}/dtml/{$template}");
            }
    }
}
?>