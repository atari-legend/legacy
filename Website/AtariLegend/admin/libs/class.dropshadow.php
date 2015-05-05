<?php

//
// class.dropshadow.php
// version 2.0.0, 21st May, 2003
//
// License
//
// PHP class to create thumbnails of images and/or to add a drop shadow effect.
//
// Copyright (C) 2002 Andrew Collington, php@amnuts.com, http://php.amnuts.com/
//
// This program is free software; you can redistribute it and/or modify it under
// the terms of the GNU General Public License as published by the Free Software
// Foundation; either version 2 of the License, or (at your option) any later
// version.
//
// This program is distributed in the hope that it will be useful, but WITHOUT
// ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
// FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with
// this program; if not, write to the Free Software Foundation, Inc., 59 Temple
// Place - Suite 330, Boston, MA 02111-1307, USA.
//
// Description
//
// This class allows for easy creation of images with a drop shadow effect.
// Images can be read from a file or passed as a string (as you might take
// the images from a database), and they can also be resized for easy
// creation of thumbnails.  You can also change the background colour of
// the image and generate the correct colour through the shadow.
//
// Requirements
//
// PHP 4.1.0+, GD 2.0.1+
//
// Shadow images
//
// I found that the best way to create a drop shadow was to first create
// the shadow in an art program, and then split it up into 8 seperate
// pieces; top left corner, top line, top right corner, left side, right
// side, bottom left corner, bottom line, and bottom right corner.
//
// If you don't like the spacing of the drop shadow, then you could easily
// create your own drop shadows and over-write the files supplied.  The
// different sizes of the drop-shadow images should be automatically taken
// into consideration.  If you create your own shadows then you must save
// them as PNG-24 (24-bit), as that level of alpha channels is required.
//
// If no drop-shadow images can be located (or it cannot load up all of the
// images) then it will still save the image (resized if you told it to be),
// just without the drop-shadow effect.
//
//
// Andrew Collington, 2003
// php@amnuts.com, http://php.amnuts.com/
//



class dropShadow
{
    var $_imgOrig;       // the original image
    var $_imgFinal;      // the final image, resized
    var $_imgShadow;     // the final image with a drop shadow, if applied
    var $_shadows;       // the dropshadow image array
    var $_shadowPath;    // the path to the dropshadow images
    var $_showDebug;     // debugging on/off (TRUE/FALSE)
    
    //
    // Constructor
    //
    

    function dropShadow($debug = FALSE)
    {
        $this->_showDebug = ($debug ? TRUE : FALSE);
        $this->_imgOrig = $this->_imgFinal = $this->_imgFinal = NULL;
        $this->_shadows = array();
    }


    //
    // User called functions
    //


    //
    // loads the original image.  If no extension is passed to $forceext then it will attempt
    // to load the correct type based on the $filename.
    //
    function loadImage($filename, $forceext = '')
    {
        if (!@file_exists($filename))
        {
            $this->_debug('loadImage', "The supplied file name '$filename' does not point to an existing file.");
            return FALSE;
        }
        
        $ext = ($forceext == '' ? $this->_getExtension($filename) : $forceext);
        if ($ext == 'jpg') $ext = 'jpeg';

        $func = "imagecreatefrom$ext";
        
        if (!@function_exists($func))
        {
            $this->_debug('loadImage', "That file cannot be loaded with the function '$func'.");
            return FALSE;
        }
        
        $this->_imgOrig = @$func($filename);
        
        if ($this->_imgOrig == NULL)
        {
            $this->_debug('loadImage', 'The image could not be loaded.');
            return FALSE;
        }
        
        return TRUE;
    }
    
    //
    // load an image from a string, for example, from a database row
    //
    function loadImageFromString($string)
    {
        $this->_imgOrig = @ImageCreateFromString($string);
        if ($this->_imgOrig == NULL)
        {
            $this->_debug('loadImageFromString', 'The image could not be loaded.');
            return FALSE;
        }
        
        return TRUE;
    }

    //
    // saves the final image resource to the file system.  If no extension is given for $forceext
    // then it will attempt to save based on the file name.
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    //
    function saveFinal($filename, $forcetype = '', $quality = 80)
    {
        return ($this->_saveImage($filename, $this->_imgFinal, $forcetype, $quality));
    }

    //
    // saves the final image resource to the file system.  If no extension is given for $forceext
    // then it will attempt to save based on the file name.
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    //
    function saveShadow($filename, $forcetype = '', $quality = 80)
    {
        return ($this->_saveImage($filename, $this->_imgShadow, $forcetype, $quality));
    }

    //
    // show the final image as either a png or jpg
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    //
    function showFinal($type = 'png', $quality = 80)
    {
        return ($this->_showImage($this->_imgFinal, $type, $quality));
    }
    
    //
    // show the final shadowed image as either a png or jpg
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    //
    function showShadow($type = 'png', $quality = 100)
    {
        return ($this->_showImage($this->_imgShadow, $type, $quality));
    }

    //
    // allows you to set where the drop-shadow images will be located
    //
    function setShadowPath($path = '.')
    {
        $this->_shadowPath = realpath($path);
        if ($this->_shadowPath[strlen($this->_shadowPath)-1] != '/') $this->_shadowPath .= '/';
    }

    //
    // resize the original image by a certain pixel size
    // if 0 is supplied for $x or $y then the resize will be proportional
    //
    function resizeBySize($x, $y)
    {
        $nx = @ImageSX($this->_imgOrig) - $x;
        $ny = @ImageSY($this->_imgOrig) - $y;
        if ($x == 0) list($nx, $ny) = $this->_getProportionalSize(0, $ny);
        if ($y == 0) list($nx, $ny) = $this->_getProportionalSize($nx, 0);
        $this->_debug('resizeBySize', "Image size is $nx / $ny");
        return ($this->_resizeImage($nx, $ny, 'resizeBySize'));
    }

    //
    // resize the original image to a certain pixel size
    // if 0 is supplied for $x or $y then the resize will be proportional
    //
    function resizeToSize($x, $y)
    {
        $nx = $x;
        $ny = $y;
        if ($x == 0) list($nx, $ny) = $this->_getProportionalSize(0, $y);
        if ($y == 0) list($nx, $ny) = $this->_getProportionalSize($x, 0);
        $this->_debug('resizeToSize', "Image size is $nx / $ny");
        return ($this->_resizeImage($nx, $ny, 'resizeToSize'));
    }

    //
    // resize the original image by a certain percent of the original
    // if 0 is supplied for $percentx or $percenty then the resize will be proportional
    //
    function resizeByPercent($percentx, $percenty)
    {
        $nx = @ImageSX($this->_imgOrig) - (($percentx / 100) * @ImageSX($this->_imgOrig));
        $ny = @ImageSY($this->_imgOrig) - (($percenty / 100) * @ImageSY($this->_imgOrig));
        if ($percentx == 0) list($nx, $ny) = $this->_getProportionalSize(0, $ny);
        if ($percenty == 0) list($nx, $ny) = $this->_getProportionalSize($nx, 0);
        $this->_debug('resizeByPercent', "Image size is $nx / $ny");
        return ($this->_resizeImage($nx, $ny, 'resizeByPercent'));
    }

    //
    // resize the original image to a certain percent of the original
    // if 0 is supplied for $percentx or $percenty then the resize will be proportional
    //
    function resizeToPercent($percentx, $percenty)
    {
        $nx = ($percentx / 100) * @ImageSX($this->_imgOrig);
        $ny = ($percenty / 100) * @ImageSY($this->_imgOrig);
        if ($percentx == 0) list($nx, $ny) = $this->_getProportionalSize(0, $ny);
        if ($percenty == 0) list($nx, $ny) = $this->_getProportionalSize($nx, 0);
        $this->_debug('resizeToPercent', "Image size is $nx / $ny");
        return ($this->_resizeImage($nx, $ny, 'resizeToPercent'));
    }

    //
    // apply the drop shadow to the final image resource
    // this will overwrite the final image resource with the drop-shadowed version
    // the background colour can be changed by passing an HTML hex value (with or without the #)
    //
    function applyShadow($bgcolour = 'FFFFFF')
    {
        // make sure we have the image resource
        if ($this->_imgFinal == NULL)
        {
            $this->_debug('applyShadow', 'There is no resized image, so the original image is being used.');
            if ($this->_imgOrig == NULL)
            {
                $this->_debug('applyShadow', 'There is no original image loaded.');
                return FALSE;
            }
            $this->_resizeImage(@ImageSX($this->_imgOrig), @ImageSY($this->_imgOrig), 'applyShadow');
            if ($this->_imgFinal == NULL)
            {
                $this->_debug('applyShadow', 'The destination image could not be created.');
                return FALSE;
            }
        }

        // attempt to load the drop shadow array
        if ($this->_shadows['l']  == NULL) $this->_shadows['l']  = @ImageCreateFromPNG($this->_shadowPath . "ds_left.png");
        if ($this->_shadows['r']  == NULL) $this->_shadows['r']  = @ImageCreateFromPNG($this->_shadowPath . "ds_right.png");
        if ($this->_shadows['t']  == NULL) $this->_shadows['t']  = @ImageCreateFromPNG($this->_shadowPath . "ds_top.png");
        if ($this->_shadows['b']  == NULL) $this->_shadows['b']  = @ImageCreateFromPNG($this->_shadowPath . "ds_bottom.png");
        if ($this->_shadows['tl'] == NULL) $this->_shadows['tl'] = @ImageCreateFromPNG($this->_shadowPath . "ds_tlcorner.png");
        if ($this->_shadows['tr'] == NULL) $this->_shadows['tr'] = @ImageCreateFromPNG($this->_shadowPath . "ds_trcorner.png");
        if ($this->_shadows['bl'] == NULL) $this->_shadows['bl'] = @ImageCreateFromPNG($this->_shadowPath . "ds_blcorner.png");
        if ($this->_shadows['br'] == NULL) $this->_shadows['br'] = @ImageCreateFromPNG($this->_shadowPath . "ds_brcorner.png");

        // verify all is well
        foreach($this->_shadows as $key => $val)
        {
            if ($val == NULL)
            {
                $this->_debug('applyShadow', 'The shadow files could not be loaded.');
                return FALSE;
            }
        }

        // create go-between image
        $ox = @ImageSX($this->_imgFinal);
        $oy = @ImageSY($this->_imgFinal);
        $nx = @ImageSX($this->_shadows['l']) + @ImageSX($this->_shadows['r']) + @ImageSX($this->_imgFinal);
        $ny = @ImageSY($this->_shadows['t']) + @ImageSY($this->_shadows['b']) + @ImageSY($this->_imgFinal);

        $this->_debug('applyShadow', "Original image size = $ox/$oy : Drop shadowed image size = $nx/$ny");

        $this->_imgShadow = @ImageCreateTrueColor($nx, $ny);
        if ($this->_imgShadow == NULL)
        {
            $this->_debug('applyShadow', 'The drop-shadowed image resource could not be created.');
            return FALSE;
        }

        // pre-process the image
        $background = $this->_htmlHexToBinArray($bgcolour);
        @ImageAlphaBlending($this->_imgShadow, TRUE);
        @ImageFill($this->_imgShadow, 0, 0, @ImageColorAllocate($this->_imgShadow, $background[0], $background[1], $background[2]));

        // apply the shadow

        // top left corner
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['tl'],
                        0, 0, 0, 0,
                        @ImageSX($this->_shadows['tl']), @ImageSY($this->_shadows['tl']), @ImageSX($this->_shadows['tl']), @ImageSY($this->_shadows['tl']));
        // top shadow
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['t'],
                        @ImageSX($this->_shadows['l']), 0, 0, 0,
                        $ox, @ImageSY($this->_shadows['t']), @ImageSX($this->_shadows['t']), @ImageSY($this->_shadows['t']));
        // top right corner
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['tr'],
                        ($nx - @ImageSX($this->_shadows['r'])), 0, 0, 0,
                        @ImageSX($this->_shadows['tr']), @ImageSY($this->_shadows['tr']), @ImageSX($this->_shadows['tr']), @ImageSY($this->_shadows['tr']));
        // left shadow
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['l'],
                        0, @ImageSY($this->_shadows['t']),    0, 0,
                        @ImageSX($this->_shadows['l']), $oy, @ImageSX($this->_shadows['l']), @ImageSY($this->_shadows['l']));
        // right shadow
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['r'],
                        ($nx - @ImageSX($this->_shadows['r'])), @ImageSY($this->_shadows['tl']), 0, 0,
                        @ImageSX($this->_shadows['r']), $oy, @ImageSX($this->_shadows['r']), @ImageSY($this->_shadows['r']));
        // bottom left corner
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['bl'],
                        0, ($ny - @ImageSY($this->_shadows['b'])), 0, 0,
                        @ImageSX($this->_shadows['bl']), @ImageSY($this->_shadows['bl']), @ImageSX($this->_shadows['bl']), @ImageSY($this->_shadows['bl']));
        // bottom shadow
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['b'],
                        @ImageSX($this->_shadows['l']), ($ny - @ImageSY($this->_shadows['b'])), 0, 0,
                        $ox, @ImageSY($this->_shadows['b']), @ImageSX($this->_shadows['b']), @ImageSY($this->_shadows['b']));
        // bottom right corner
        @ImageCopyResampled($this->_imgShadow, $this->_shadows['br'],
                        ($nx - @ImageSX($this->_shadows['r'])), ($ny - @ImageSY($this->_shadows['b'])), 0, 0,
                        @ImageSX($this->_shadows['br']), @ImageSY($this->_shadows['br']), @ImageSX($this->_shadows['br']), @ImageSY($this->_shadows['br']));

        // apply the picture
        @ImageCopyResampled($this->_imgShadow, $this->_imgFinal,
                        @ImageSX($this->_shadows['l']), @ImageSY($this->_shadows['t']), 0, 0,
                        $ox, $oy, @ImageSX($this->_imgFinal), @ImageSY($this->_imgFinal));

        return TRUE;
    }

    //
    // clean up image resources
    // 0 = original image only
    // 1 = final image only
    // 2 = shadow images only
    // 3 = all images
    //
    function flushImages($which = 5)
    {
        switch ($which)
        {
            case 0:
                @ImageDestroy($this->_imgOrig);
                $this->_imgOrig = NULL;
                break;
            case 1:
                @ImageDestroy($this->_imgFinal);
                $this->_imgFinal = NULL;
                break;
            case 3:
                @ImageDestroy($this->_imgShadow);
                $this->_imgShadow = NULL;
                break;
            case 4:
                @ImageDestroy($this->_shadows['l']);
                @ImageDestroy($this->_shadows['r']);
                @ImageDestroy($this->_shadows['t']);
                @ImageDestroy($this->_shadows['b']);
                @ImageDestroy($this->_shadows['tl']);
                @ImageDestroy($this->_shadows['tr']);
                @ImageDestroy($this->_shadows['bl']);
                @ImageDestroy($this->_shadows['br']);
                unset($this->_shadows);
                break;
            case 5:
                @ImageDestroy($this->_imgOrig);
                @ImageDestroy($this->_imgFinal);
                @ImageDestroy($this->_imgShadow);
                @ImageDestroy($this->_shadows['l']);
                @ImageDestroy($this->_shadows['r']);
                @ImageDestroy($this->_shadows['t']);
                @ImageDestroy($this->_shadows['b']);
                @ImageDestroy($this->_shadows['tl']);
                @ImageDestroy($this->_shadows['tr']);
                @ImageDestroy($this->_shadows['bl']);
                @ImageDestroy($this->_shadows['br']);
                $this->_imgOrig = $this->_imgFinal = $this->_imgShadow = NULL;
                unset($this->_shadows);
                break;
        }
    }


    
    //
    // Internal functions
    //


    //
    // get the file extension of the given filename
    //
    function _getExtension($filename)
    {
        $ext  = strtolower(substr($filename, (strrpos($filename, '.') ? strrpos($filename, '.') + 1 : strlen($filename)), strlen($filename)));
        if ($ext == 'jpg') $ext = 'jpeg';
        return $ext;
    }
    
    //
    // if only the width is supplied, get the height based on the original image size
    // if only the height is supplied, get the width based on the original image size
    //
    function _getProportionalSize($x, $y)
    {
        if (!$x) $x = ($y / ImageSY($this->_imgOrig)) * ImageSX($this->_imgOrig);
        else $y = ImageSY($this->_imgOrig) / (ImageSX($this->_imgOrig) / $x);
        return array($x, $y);
    }

    //
    // core functionality for the resizing of an image
    //
    function _resizeImage($nx, $ny, $function)
    {
        if ($this->_imgOrig == NULL)
        {
            $this->_debug($function, 'The original image has not been loaded.');
            return FALSE;
        }
        if (($nx < 0) || ($ny < 0))
        {
            $this->_debug($function, 'The image could not be resized because the size given is not valid.');
            return FALSE;
        }
        if ($this->_imgFinal) $this->flushImages(1);
        $this->_imgFinal = @ImageCreateTrueColor($nx, $ny);
        @ImageCopyResampled($this->_imgFinal, $this->_imgOrig, 0, 0, 0, 0, $nx, $ny, @ImageSX($this->_imgOrig), @ImageSY($this->_imgOrig));
    }

    //
    // show the final image as either a png or jpg
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    //
    function _showImage($resource, $type, $quality)
    {
        if ($resource == NULL)
        {
            $this->_debug('_showImage', 'There is no processed image to show.');
            return FALSE;
        }
        if ($type == 'png')
        {
            header('Content-Type: image/png');
            echo @ImagePNG($resource);
            return TRUE;
        }
        else if ($type == 'jpg' || $type == 'jpeg')
        {
            header('Content-Type: image/jpeg');
            echo @ImageJPEG($resource, '', $quality);
            return TRUE;
        }
        else
        {
            $this->_debug('_showImage', "Could not show the output file as a $type.");
            return FALSE;
        }
    }

    //
    // saves the image resource to the file system.  If no extension is given for $type
    // then it will attempt to save based on the file name.
    // $quality is a value from 1 to 100, inclusive, and only used when outputting as a jpg
    // $img is the image resource
    //
    function _saveImage($filename, $img, $type, $quality)
    {
        if ($img == NULL)
        {
            $this->_debug('_saveImage', 'There is no processed image to save.');
            return FALSE;
        }

        $ext = ($type == '' ? $this->_getExtension($filename) : $type);
        if ($ext == 'jpg') $ext = 'jpeg';
        $func = "image$ext";
        
        if (!@function_exists($func))
        {
            $this->_debug('_saveImage', "That file cannot be saved with the function '$func'.");
            return FALSE;
        }

        if ($ext == 'png') $saved = @$func($img, $filename);
        if ($ext == 'jpeg') $saved = @$func($img, $filename, $quality);
        if ($saved == FALSE)
        {
            $this->_debug('_saveImage', "Could not save the output file '$filename' as a $ext.");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    //
    // convert HTML hex value into integer array
    //
    function _htmlHexToBinArray($hex)
    {
        $hex = @preg_replace('/^#/', '', $hex);
        for ($i=0; $i<3; $i++)
        {
            $foo = substr($hex, 2*$i, 2); 
            $rgb[$i] = 16 * hexdec(substr($foo, 0, 1)) + hexdec(substr($foo, 1, 1)); 
        }
        return $rgb;
    }

    //
    // write out some debugging information to screen
    //
    function _debug($function, $string)
    {
        if ($this->_showDebug)
        {
            echo "<p><strong style=\"color:#FF0000\">Debug message from function $function:</strong> $string</p>\n";
        }
    }
}
?>