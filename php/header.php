<?php
header("Access-Control-Allow-Origin: *");

function getHeader()
{
    $html =
        '
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Access-Control-Allow-Origin: *">
        <style type="text/css">
            @import url(https://themes.googleusercontent.com/fonts/css?kit=fpjTOVmNbO4Lz34iLyptLUXza5VhXqVC6o75Eld_V98);

            .lst-kix_ids0kh6fgwh6-8>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-8
            }

            ol.lst-kix_mgv3u350gf9c-2.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-2 0
            }

            .lst-kix_c6dd2gfpxdvp-0>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-0
            }

            .lst-kix_mgv3u350gf9c-6>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-6, decimal) ". "
            }

            .lst-kix_mgv3u350gf9c-7>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-7, lower-latin) ". "
            }

            .lst-kix_ids0kh6fgwh6-7>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-7
            }

            .lst-kix_mgv3u350gf9c-8>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-8, lower-roman) ". "
            }

            ol.lst-kix_c6dd2gfpxdvp-7.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-7 0
            }

            .lst-kix_mgv3u350gf9c-0>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-0, decimal) ". "
            }

            ol.lst-kix_ids0kh6fgwh6-7.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-7 0
            }

            .lst-kix_mgv3u350gf9c-0>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-0
            }

            ol.lst-kix_ids0kh6fgwh6-4.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-4 0
            }

            .lst-kix_m2q19ci6w6ni-1>li:before {
                content: "\0025cb   "
            }

            .lst-kix_m2q19ci6w6ni-2>li:before {
                content: "\0025a0   "
            }

            .lst-kix_mgv3u350gf9c-5>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-5, lower-roman) ". "
            }

            .lst-kix_m2q19ci6w6ni-0>li:before {
                content: "\0025cf   "
            }

            .lst-kix_m2q19ci6w6ni-3>li:before {
                content: "\0025cf   "
            }

            .lst-kix_m2q19ci6w6ni-4>li:before {
                content: "\0025cb   "
            }

            .lst-kix_mgv3u350gf9c-4>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-4, lower-latin) ". "
            }

            .lst-kix_mgv3u350gf9c-1>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-1, lower-latin) ". "
            }

            .lst-kix_mgv3u350gf9c-3>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-3, decimal) ". "
            }

            .lst-kix_mgv3u350gf9c-2>li:before {
                content: ""counter(lst-ctn-kix_mgv3u350gf9c-2, lower-roman) ". "
            }

            .lst-kix_mgv3u350gf9c-1>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-1
            }

            .lst-kix_mgv3u350gf9c-7>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-7
            }

            ol.lst-kix_c6dd2gfpxdvp-5.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-5 0
            }

            ol.lst-kix_ids0kh6fgwh6-8.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-8 0
            }

            ol.lst-kix_mgv3u350gf9c-4.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-4 0
            }

            .lst-kix_ids0kh6fgwh6-6>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-6
            }

            ol.lst-kix_ids0kh6fgwh6-1.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-1 0
            }

            .lst-kix_ids0kh6fgwh6-0>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-0
            }

            .lst-kix_c6dd2gfpxdvp-7>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-7
            }

            ol.lst-kix_ids0kh6fgwh6-2.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-2 0
            }

            .lst-kix_ids0kh6fgwh6-8>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-8, lower-roman) ". "
            }

            .lst-kix_c6dd2gfpxdvp-4>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-4
            }

            ol.lst-kix_c6dd2gfpxdvp-4.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-4 0
            }

            .lst-kix_ids0kh6fgwh6-6>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-6, decimal) ". "
            }

            .lst-kix_ids0kh6fgwh6-7>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-7, lower-latin) ". "
            }

            .lst-kix_ids0kh6fgwh6-0>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-0, decimal) ". "
            }

            .lst-kix_ids0kh6fgwh6-2>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-2, lower-roman) ". "
            }

            ol.lst-kix_mgv3u350gf9c-5.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-5 0
            }

            .lst-kix_ids0kh6fgwh6-1>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-1, lower-latin) ". "
            }

            .lst-kix_ids0kh6fgwh6-5>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-5, lower-roman) ". "
            }

            .lst-kix_ids0kh6fgwh6-4>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-4, lower-latin) ". "
            }

            .lst-kix_c6dd2gfpxdvp-1>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-1
            }

            .lst-kix_ids0kh6fgwh6-3>li:before {
                content: ""counter(lst-ctn-kix_ids0kh6fgwh6-3, decimal) ". "
            }

            .lst-kix_mgv3u350gf9c-4>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-4
            }

            ol.lst-kix_c6dd2gfpxdvp-0.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-0 0
            }

            ul.lst-kix_m2q19ci6w6ni-0 {
                list-style-type: none
            }

            .lst-kix_ids0kh6fgwh6-2>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-2
            }

            ul.lst-kix_m2q19ci6w6ni-1 {
                list-style-type: none
            }

            ul.lst-kix_m2q19ci6w6ni-2 {
                list-style-type: none
            }

            ul.lst-kix_m2q19ci6w6ni-3 {
                list-style-type: none
            }

            ul.lst-kix_m2q19ci6w6ni-4 {
                list-style-type: none
            }

            ul.lst-kix_m2q19ci6w6ni-5 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-8 {
                list-style-type: none
            }

            ul.lst-kix_m2q19ci6w6ni-6 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-3.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-3 0
            }

            ul.lst-kix_m2q19ci6w6ni-7 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-6 {
                list-style-type: none
            }

            .lst-kix_c6dd2gfpxdvp-5>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-5
            }

            ul.lst-kix_m2q19ci6w6ni-8 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-7 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-4 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-5 {
                list-style-type: none
            }

            .lst-kix_c6dd2gfpxdvp-0>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-0, decimal) ". "
            }

            .lst-kix_ids0kh6fgwh6-3>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-3
            }

            .lst-kix_c6dd2gfpxdvp-1>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-1, lower-latin) ". "
            }

            ol.lst-kix_ids0kh6fgwh6-6.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-6 0
            }

            .lst-kix_c6dd2gfpxdvp-6>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-6
            }

            ol.lst-kix_c6dd2gfpxdvp-0 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-2 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-1 {
                list-style-type: none
            }

            .lst-kix_c6dd2gfpxdvp-6>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-6, decimal) ". "
            }

            .lst-kix_c6dd2gfpxdvp-8>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-8, lower-roman) ". "
            }

            ol.lst-kix_c6dd2gfpxdvp-4 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-3 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-6 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-6.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-6 0
            }

            .lst-kix_c6dd2gfpxdvp-5>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-5, lower-roman) ". "
            }

            ol.lst-kix_c6dd2gfpxdvp-5 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-6.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-6 0
            }

            ol.lst-kix_c6dd2gfpxdvp-8 {
                list-style-type: none
            }

            .lst-kix_ids0kh6fgwh6-1>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-1
            }

            .lst-kix_ids0kh6fgwh6-4>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-4
            }

            ol.lst-kix_c6dd2gfpxdvp-7 {
                list-style-type: none
            }

            .lst-kix_c6dd2gfpxdvp-2>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-2, lower-roman) ". "
            }

            .lst-kix_c6dd2gfpxdvp-4>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-4, lower-latin) ". "
            }

            .lst-kix_c6dd2gfpxdvp-3>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-3, decimal) ". "
            }

            ol.lst-kix_ids0kh6fgwh6-2 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-3 {
                list-style-type: none
            }

            ol.lst-kix_ids0kh6fgwh6-0 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-3.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-3 0
            }

            ol.lst-kix_ids0kh6fgwh6-1 {
                list-style-type: none
            }

            .lst-kix_mgv3u350gf9c-3>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-3
            }

            ol.lst-kix_ids0kh6fgwh6-0.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-0 0
            }

            .lst-kix_c6dd2gfpxdvp-8>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-8
            }

            ol.lst-kix_mgv3u350gf9c-0.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-0 0
            }

            ol.lst-kix_mgv3u350gf9c-3.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-3 0
            }

            .lst-kix_mgv3u350gf9c-6>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-6
            }

            .lst-kix_c6dd2gfpxdvp-7>li:before {
                content: ""counter(lst-ctn-kix_c6dd2gfpxdvp-7, lower-latin) ". "
            }

            .lst-kix_ids0kh6fgwh6-5>li {
                counter-increment: lst-ctn-kix_ids0kh6fgwh6-5
            }

            .lst-kix_m2q19ci6w6ni-7>li:before {
                content: "\0025cb   "
            }

            .lst-kix_m2q19ci6w6ni-8>li:before {
                content: "\0025a0   "
            }

            ol.lst-kix_mgv3u350gf9c-7.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-7 0
            }

            .lst-kix_m2q19ci6w6ni-5>li:before {
                content: "\0025a0   "
            }

            .lst-kix_m2q19ci6w6ni-6>li:before {
                content: "\0025cf   "
            }

            .lst-kix_c6dd2gfpxdvp-2>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-2
            }

            ol.lst-kix_c6dd2gfpxdvp-2.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-2 0
            }

            .lst-kix_c6dd2gfpxdvp-3>li {
                counter-increment: lst-ctn-kix_c6dd2gfpxdvp-3
            }

            ol.lst-kix_mgv3u350gf9c-1.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-1 0
            }

            .lst-kix_mgv3u350gf9c-8>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-8
            }

            ol.lst-kix_c6dd2gfpxdvp-1.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-1 0
            }

            .lst-kix_mgv3u350gf9c-5>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-5
            }

            .lst-kix_mgv3u350gf9c-2>li {
                counter-increment: lst-ctn-kix_mgv3u350gf9c-2
            }

            ol.lst-kix_ids0kh6fgwh6-5.start {
                counter-reset: lst-ctn-kix_ids0kh6fgwh6-5 0
            }

            ol.lst-kix_mgv3u350gf9c-8 {
                list-style-type: none
            }

            ol.lst-kix_c6dd2gfpxdvp-8.start {
                counter-reset: lst-ctn-kix_c6dd2gfpxdvp-8 0
            }

            ol.lst-kix_mgv3u350gf9c-6 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-7 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-4 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-5 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-2 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-3 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-0 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-1 {
                list-style-type: none
            }

            ol.lst-kix_mgv3u350gf9c-8.start {
                counter-reset: lst-ctn-kix_mgv3u350gf9c-8 0
            }

            ol {
                margin: 0;
                padding: 0
            }

            table td,
            table th {
                padding: 0
            }

            .c51 {
                border-right-style: solid;
                padding-top: 0pt;
                border-top-width: 0pt;
                border-right-width: 0pt;
                padding-left: 0pt;
                padding-bottom: 0pt;
                line-height: 1.625;
                border-left-width: 0pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 0pt;
                border-bottom-style: solid;
                text-align: left;
                padding-right: 0pt
            }

            .c38 {
                border-right-style: solid;
                padding-top: 0pt;
                border-top-width: 0pt;
                border-right-width: 0pt;
                padding-left: 0pt;
                padding-bottom: 0pt;
                line-height: 1.625;
                border-top-style: solid;
                margin-left: 59pt;
                border-bottom-width: 0pt;
                border-bottom-style: solid;
                text-align: left;
                padding-right: 0pt
            }

            .c26 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 80.2pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c15 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 416.2pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c61 {
                border-right-style: solid;
                padding-top: 0pt;
                border-top-width: 0pt;
                border-right-width: 0pt;
                padding-bottom: 0pt;
                line-height: 1.625;
                border-top-style: solid;
                margin-left: 36pt;
                border-bottom-width: 0pt;
                border-bottom-style: solid;
                text-align: left;
                padding-right: 0pt
            }

            .c19 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 117pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c31 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #e69138;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #e69138;
                vertical-align: top;
                border-right-color: #e69138;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 16.8pt;
                border-top-color: #e69138;
                border-bottom-style: solid
            }

            .c18 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 24.8pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c36 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #e69138;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #e69138;
                vertical-align: top;
                border-right-color: #e69138;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 217.4pt;
                border-top-color: #e69138;
                border-bottom-style: solid
            }

            .c29 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 106.5pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c37 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 123pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c17 {
                border-right-style: solid;
                padding: 5pt 5pt 5pt 5pt;
                border-bottom-color: #000000;
                border-top-width: 1pt;
                border-right-width: 1pt;
                border-left-color: #000000;
                vertical-align: top;
                border-right-color: #000000;
                border-left-width: 1pt;
                border-top-style: solid;
                border-left-style: solid;
                border-bottom-width: 1pt;
                width: 33.8pt;
                border-top-color: #000000;
                border-bottom-style: solid
            }

            .c1 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 10pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c8 {
                color: #000000;
                font-weight: 700;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 11pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c6 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 12pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c0 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 11pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c14 {
                color: #ff0000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 10pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c13 {
                margin-left: 18pt;
                padding-top: 3pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c33 {
                color: #000000;
                font-weight: 700;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 14pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c7 {
                padding-top: 16pt;
                padding-bottom: 4pt;
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c3 {
                color: #000000;
                font-weight: 700;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 10pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c9 {
                padding-top: 18pt;
                padding-bottom: 6pt;
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c11 {
                color: #000000;
                font-weight: 700;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 12pt;
                font-family: "Calibri";
                font-style: normal
            }

            .c52 {
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                vertical-align: baseline;
                font-size: 8.5pt;
                font-family: "Verdana";
                font-style: normal
            }

            .c2 {
                padding-top: 4pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c40 {
                margin-left: 36pt;
                padding-top: 12pt;
                padding-left: 0pt;
                padding-bottom: 12pt;
                line-height: 1.15;
                text-align: left
            }

            .c5 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.15;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .c62 {
                margin-left: 18pt;
                padding-top: 3pt;
                padding-bottom: 4pt;
                line-height: 1.0;
                text-align: left
            }

            .c28 {
                padding-top: 20pt;
                padding-bottom: 6pt;
                line-height: 1.15;
                page-break-after: avoid;
                text-align: left
            }

            .c55 {
                padding-top: 0pt;
                padding-bottom: 3pt;
                line-height: 1.15;
                page-break-after: avoid;
                text-align: left
            }

            .c32 {
                margin-left: 36pt;
                padding-top: 3pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                text-align: left
            }

            .c41 {
                padding-top: 10pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                text-align: left
            }

            .c47 {
                padding-top: 12pt;
                padding-bottom: 12pt;
                line-height: 1.15;
                text-align: left
            }

            .c22 {
                color: #000000;
                text-decoration: none;
                vertical-align: baseline;
                font-style: italic
            }

            .c35 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.15;
                text-align: right
            }

            .c25 {
                -webkit-text-decoration-skip: none;
                color: #1155cc;
                text-decoration: underline;
                text-decoration-skip-ink: none
            }

            .c12 {
                padding-top: 0pt;
                padding-bottom: 0pt;
                line-height: 1.0;
                text-align: left
            }

            .c45 {
                border-spacing: 0;
                border-collapse: collapse;
                margin-right: auto
            }

            .c30 {
                font-size: 10pt;
                font-family: "Calibri";
                font-weight: 700
            }

            .c21 {
                font-size: 10pt;
                font-family: "Calibri";
                font-weight: 400
            }

            .c10 {
                font-family: "Calibri";
                font-style: italic;
                font-weight: 400
            }

            .c58 {
                font-size: 8.5pt;
                font-family: "Verdana";
                font-weight: 400
            }

            .c56 {
                text-decoration: none;
                vertical-align: baseline;
                font-style: normal
            }

            .c4 {
                color: inherit;
                text-decoration: inherit
            }

            .c20 {
                orphans: 2;
                widows: 2
            }

            .c59 {
                color: #555555;
                font-size: 12pt
            }

            .c39 {
                font-weight: 700;
                font-family: "Calibri"
            }

            .c49 {
                margin-left: 36pt;
                padding-left: 0pt
            }

            .c42 {
                padding: 0;
                margin: 0
            }

            .c65 {
                color: #dd0099;
                font-size: 12pt
            }

            .c63 {
                max-width: 451.4pt;
                padding: 72pt 72pt 72pt 72pt
            }

            .c24 {
                font-family: "Calibri";
                font-weight: 400
            }

            .c34 {
                background-color: #d9ead3
            }

            .c16 {
                height: 10pt
            }

            .c60 {
                font-size: 26pt
            }

            .c66 {
                font-size: 16pt
            }

            .c54 {
                background-color: #f1f1f1
            }

            .c23 {
                background-color: #ffffff
            }

            .c27 {
                height: 0pt
            }

            .c44 {
                color: #ff0000
            }

            .c46 {
                height: 14pt
            }

            .c50 {
                height: 12pt
            }

            .c57 {
                color: #000000
            }

            .c53 {
                font-size: 11pt
            }

            .c43 {
                font-style: italic
            }

            .c64 {
                height: 16.5pt
            }

            .c48 {
                font-size: 10pt
            }

            .c67 {
                color: #343a40
            }

            .title {
                padding-top: 0pt;
                color: #000000;
                font-size: 26pt;
                padding-bottom: 3pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            .subtitle {
                padding-top: 0pt;
                color: #666666;
                font-size: 15pt;
                padding-bottom: 16pt;
                font-family: "Arial";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            li {
                color: #000000;
                font-size: 10pt;
                font-family: "Calibri"
            }

            p {
                margin: 0;
                color: #000000;
                font-size: 10pt;
                font-family: "Calibri"
            }

            h1 {
                padding-top: 20pt;
                color: #000000;
                font-weight: 700;
                font-size: 14pt;
                padding-bottom: 6pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h2 {
                padding-top: 18pt;
                color: #000000;
                font-weight: 700;
                font-size: 12pt;
                padding-bottom: 6pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h3 {
                padding-top: 16pt;
                color: #000000;
                font-weight: 700;
                font-size: 10pt;
                padding-bottom: 4pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h4 {
                padding-top: 14pt;
                color: #666666;
                font-size: 12pt;
                padding-bottom: 4pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h5 {
                padding-top: 12pt;
                color: #666666;
                font-size: 11pt;
                padding-bottom: 4pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                orphans: 2;
                widows: 2;
                text-align: left
            }

            h6 {
                padding-top: 12pt;
                color: #666666;
                font-size: 11pt;
                padding-bottom: 4pt;
                font-family: "Calibri";
                line-height: 1.15;
                page-break-after: avoid;
                font-style: italic;
                orphans: 2;
                widows: 2;
                text-align: left
            }
        </style>
    </head>

    <body class="c23 c63">
        <div>
            <p class="c5 c16"><span class="c1"></span></p>
        </div>';

    return $html;
}
