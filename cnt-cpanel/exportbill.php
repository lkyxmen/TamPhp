<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|     Email: PeakOfMusic@Gmail.Com    |
\*-----------------------------------*/

define('CNT',true);
include('../cnt-includes/config.php');
include('../cnt-includes/functions.php');

if (check_log() & check_level() >= 3) {
    $data = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <?mso-application progid="Word.Document"?>
    <w:wordDocument xmlns:w="http://schemas.microsoft.com/office/word/2003/wordml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:sl="http://schemas.microsoft.com/schemaLibrary/2003/core" xmlns:aml="http://schemas.microsoft.com/aml/2001/core" xmlns:wx="http://schemas.microsoft.com/office/word/2003/auxHint" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:dt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882" xmlns:wsp="http://schemas.microsoft.com/office/word/2003/wordml/sp2" w:macrosPresent="no" w:embeddedObjPresent="no" w:ocxPresent="no" xml:space="preserve">
    <w:ignoreElements w:val="http://schemas.microsoft.com/office/word/2003/wordml/sp2"/>
    <o:DocumentProperties>
    <o:Title>'.get_option('name').'</o:Title>
    <o:Author>Trần Trung Hiếu</o:Author>
    <o:LastAuthor>Trần Trung Hiếu</o:LastAuthor>
    <o:Revision>1</o:Revision>
    <o:TotalTime>31</o:TotalTime>
    <o:Created>2010-08-12T11:34:00Z</o:Created>
    <o:LastSaved>2010-08-12T12:05:00Z</o:LastSaved>
    <o:Pages>1</o:Pages>
    <o:Words>128</o:Words>
    <o:Characters>735</o:Characters>
    <o:Company>- ETH0 -</o:Company>
    <o:Lines>6</o:Lines>
    <o:Paragraphs>1</o:Paragraphs>
    <o:CharactersWithSpaces>862</o:CharactersWithSpaces>
    <o:Version>11.0000</o:Version>
    </o:DocumentProperties>
    <w:fonts>
    <w:defaultFonts w:ascii="Times New Roman" w:fareast="Times New Roman" w:h-ansi="Times New Roman" w:cs="Times New Roman"/>
    </w:fonts>
    <w:styles>
    <w:versionOfBuiltInStylenames w:val="4"/>
    <w:latentStyles w:defLockedState="off" w:latentStyleCount="156"/>
    <w:style w:type="paragraph" w:default="on" w:styleId="Normal">
    <w:name w:val="Normal"/>
    <w:rPr>
    <wx:font wx:val="Times New Roman"/>
    <w:sz w:val="24"/>
    <w:sz-cs w:val="24"/>
    <w:lang w:val="EN-US" w:fareast="EN-US" w:bidi="AR-SA"/>
    </w:rPr>
    </w:style>
    <w:style w:type="character" w:default="on" w:styleId="DefaultParagraphFont">
    <w:name w:val="Default Paragraph Font"/>
    <w:semiHidden/>
    </w:style>
    <w:style w:type="table" w:default="on" w:styleId="TableNormal">
    <w:name w:val="Normal Table"/>
    <wx:uiName wx:val="Table Normal"/>
    <w:semiHidden/>
    <w:rPr>
    <wx:font wx:val="Times New Roman"/>
    </w:rPr>
    <w:tblPr>
    <w:tblInd w:w="0" w:type="dxa"/>
    <w:tblCellMar>
    <w:top w:w="0" w:type="dxa"/>
    <w:left w:w="108" w:type="dxa"/>
    <w:bottom w:w="0" w:type="dxa"/>
    <w:right w:w="108" w:type="dxa"/>
    </w:tblCellMar>
    </w:tblPr>
    </w:style>
    <w:style w:type="list" w:default="on" w:styleId="NoList">
    <w:name w:val="No List"/>
    <w:semiHidden/>
    </w:style>
    <w:style w:type="character" w:styleId="Hyperlink">
    <w:name w:val="Hyperlink"/>
    <w:basedOn w:val="DefaultParagraphFont"/>
    <w:rsid w:val="00031696"/>
    <w:rPr>
    <w:color w:val="0000FF"/>
    <w:u w:val="single"/>
    </w:rPr>
    </w:style>
    <w:style w:type="table" w:styleId="TableGrid">
    <w:name w:val="Table Grid"/>
    <w:basedOn w:val="TableNormal"/>
    <w:rsid w:val="00406142"/>
    <w:rPr>
    <wx:font wx:val="Times New Roman"/>
    </w:rPr>
    <w:tblPr>
    <w:tblInd w:w="0" w:type="dxa"/>
    <w:tblBorders>
    <w:top w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    <w:left w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    <w:bottom w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    <w:right w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    <w:insideH w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    <w:insideV w:val="single" w:sz="4" wx:bdrwidth="10" w:space="0" w:color="auto"/>
    </w:tblBorders>
    <w:tblCellMar>
    <w:top w:w="0" w:type="dxa"/>
    <w:left w:w="108" w:type="dxa"/>
    <w:bottom w:w="0" w:type="dxa"/>
    <w:right w:w="108" w:type="dxa"/>
    </w:tblCellMar>
    </w:tblPr>
    </w:style>
    </w:styles>
    <w:docPr>
    <w:view w:val="print"/>
    <w:zoom w:percent="100"/>
    <w:doNotEmbedSystemFonts/>
    <w:hideSpellingErrors/>
    <w:hideGrammaticalErrors/>
    <w:proofState w:spelling="clean" w:grammar="clean"/>
    <w:attachedTemplate w:val=""/>
    <w:defaultTabStop w:val="720"/>
    <w:punctuationKerning/>
    <w:characterSpacingControl w:val="DontCompress"/>
    <w:optimizeForBrowser/>
    <w:validateAgainstSchema/>
    <w:saveInvalidXML w:val="off"/>
    <w:ignoreMixedContent w:val="off"/>
    <w:alwaysShowPlaceholderText w:val="off"/>
    <w:compat>
    <w:breakWrappedTables/>
    <w:snapToGridInCell/>
    <w:wrapTextWithPunct/>
    <w:useAsianBreakRules/>
    <w:dontGrowAutofit/>
    </w:compat>
    <wsp:rsids>
    <wsp:rsidRoot wsp:val="00031696"/>
    <wsp:rsid wsp:val="00031696"/>
    <wsp:rsid wsp:val="00406142"/>
    <wsp:rsid wsp:val="004169FE"/>
    <wsp:rsid wsp:val="008336C5"/>
    <wsp:rsid wsp:val="00B75EE1"/>
    <wsp:rsid wsp:val="00D53BDA"/>
    <wsp:rsid wsp:val="00F12824"/>
    </wsp:rsids>
    </w:docPr>
    <w:body>
    <wx:sect>'."\r\n";

    $bills = @mysql_query("SELECT * FROM cnt_bills WHERE bill_pay = 1");
    while ($bill = @mysql_fetch_array ($bills)){
        if($newpage == true) 
        $data .= '<w:p wsp:rsidR="00B75EE1" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1">
        <w:r>
        <w:br w:type="page"/>
        </w:r>
        </w:p>';
        else $newpage = true;
        $data .= '<w:tbl>
        <w:tblPr>
        <w:tblStyle w:val="TableGrid"/>
        <w:tblW w:w="0" w:type="auto"/>
        <w:tblBorders>
        <w:top w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        <w:left w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        <w:bottom w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        <w:right w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        <w:insideH w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        <w:insideV w:val="none" w:sz="0" wx:bdrwidth="0" w:space="0" w:color="auto"/>
        </w:tblBorders>
        <w:tblLook w:val="01E0"/>
        </w:tblPr>
        <w:tblGrid>
        <w:gridCol w:w="6048"/>
        <w:gridCol w:w="3420"/>
        </w:tblGrid>
        <w:tr wsp:rsidR="00406142" wsp:rsidTr="00B75EE1">
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="6048" w:type="dxa"/>
        </w:tcPr>
        <w:proofErr w:type="spellStart"/>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r wsp:rsidRPr="00B75EE1">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>'.get_option('name').'</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:r>
        <w:t>Website: '.get_option('url').'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="3420" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>MSHĐ : HOADON-'.$bill['id'].'</w:t>
        </w:r>
        </w:p>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>'.date('d/m/Y', $bill['bill_time']).'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        </w:tr>
        </w:tbl>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142"/>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        <w:sz w:val="28"/>
        <w:sz-cs w:val="28"/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        <w:sz w:val="28"/>
        <w:sz-cs w:val="28"/>
        </w:rPr>
        <w:t>HÓA ĐƠN BÁN HÀNG</w:t>
        </w:r>
        </w:p>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:rPr>
        <w:sz w:val="28"/>
        <w:sz-cs w:val="28"/>
        </w:rPr>
        </w:pPr>
        </w:p>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:rPr>
        <w:sz w:val="28"/>
        <w:sz-cs w:val="28"/>
        </w:rPr>
        </w:pPr>
        </w:p>
        <w:proofErr w:type="spellStart"/>
        <w:p wsp:rsidR="00D53BDA" wsp:rsidRDefault="00031696">
        <w:r wsp:rsidRPr="00031696">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Tên khách hàng: </w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        <w:proofErr w:type="spellStart"/>
        <w:r>
        <w:t>'.$bill['bill_name'].'</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        <w:proofErr w:type="spellStart"/>
        <w:p wsp:rsidR="00031696" wsp:rsidRDefault="00031696">
        <w:r wsp:rsidRPr="00031696">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Điện thoại: </w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        <w:r>
        <w:t>'.$bill['bill_phone'].'</w:t>
        </w:r>
        </w:p>
        <w:p wsp:rsidR="00031696" wsp:rsidRPr="00406142" wsp:rsidRDefault="00406142">
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Fax: </w:t>
        </w:r>
        <w:r>
        <w:t>'.(($bill['bill_fax'] == '')?'Không có':$bill['bill_fax']).'</w:t>
        </w:r>
        </w:p>
        <w:p wsp:rsidR="00031696" wsp:rsidRDefault="00031696">
        <w:r wsp:rsidRPr="00031696">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Email: </w:t>
        </w:r>
        <w:hlink w:dest="mailto:'.$bill['bill_email'].'">
        <w:r wsp:rsidRPr="006B7023">
        <w:rPr>
        <w:rStyle w:val="Hyperlink"/>
        </w:rPr>
        <w:t>'.$bill['bill_email'].'</w:t>
        </w:r>
        </w:hlink>
        </w:p>
        <w:proofErr w:type="spellStart"/>
        <w:p wsp:rsidR="00031696" wsp:rsidRDefault="00031696">
        <w:r wsp:rsidRPr="00031696">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Địa chỉ: </w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        <w:proofErr w:type="spellStart"/>
        <w:r>
        <w:t>'.$bill['bill_add'].'</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142"/>
        <w:proofErr w:type="spellStart"/>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142">
        <w:pPr>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r wsp:rsidRPr="00406142">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Danh sách sản phẩm:</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        <w:tbl>
        <w:tblPr>
        <w:tblStyle w:val="TableGrid"/>
        <w:tblW w:w="0" w:type="auto"/>
        <w:tblLook w:val="01E0"/>
        </w:tblPr>
        <w:tblGrid>
        <w:gridCol w:w="670"/>
        <w:gridCol w:w="2138"/>
        <w:gridCol w:w="1800"/>
        <w:gridCol w:w="1620"/>
        <w:gridCol w:w="1080"/>
        <w:gridCol w:w="2160"/>
        </w:tblGrid>
        <w:tr wsp:rsidR="00406142" wsp:rsidTr="00B75EE1">
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="670" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>STT</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="2138" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Tên sản phẩm</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1800" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Mã sản phẩm</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1620" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Đơn giá (VNĐ)</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1080" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Số lượng</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="2160" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRDefault="00406142" wsp:rsidP="00406142">
        <w:pPr>
        <w:jc w:val="center"/>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        <w:r>
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Thành tiền (VNĐ)</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        </w:tr>';
        $datas = explode(',',$bill['bill_content']);
        $monney = 0;
        $i = 0;
        foreach($datas as $item){
            $item = explode(':',$item);
            $product = @mysql_fetch_array(@mysql_query("SELECT product_code, product_name, product_price FROM cnt_products WHERE id = ".$item[0]));
            $p_monney = $product['product_price']*$item[1];
            $monney += $p_monney;
            $i ++;
        $data .= '<w:tr wsp:rsidR="00406142" wsp:rsidTr="00B75EE1">
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="670" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1" wsp:rsidP="00B75EE1">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>'.$i.'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:proofErr w:type="spellStart"/>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="2138" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1">
        <w:r>
        <w:t>'.$product['product_name'].'</w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        </w:p>
        </w:tc>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1800" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1">
        <w:r>
        <w:t>'.$product['product_code'].'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1620" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1" wsp:rsidP="00B75EE1">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>'.number($product['product_price']).'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="1080" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1" wsp:rsidP="00B75EE1">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>'.number($item[1]).'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        <w:tc>
        <w:tcPr>
        <w:tcW w:w="2160" w:type="dxa"/>
        </w:tcPr>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00B75EE1" wsp:rsidRDefault="00B75EE1" wsp:rsidP="00B75EE1">
        <w:pPr>
        <w:jc w:val="center"/>
        </w:pPr>
        <w:r>
        <w:t>'.number($p_monney).'</w:t>
        </w:r>
        </w:p>
        </w:tc>
        </w:tr>';
        }
        $data .= '</w:tbl>
        <w:p wsp:rsidR="00406142" wsp:rsidRPr="00406142" wsp:rsidRDefault="00406142">
        <w:pPr>
        <w:rPr>
        <w:b/>
        </w:rPr>
        </w:pPr>
        </w:p>
        <w:proofErr w:type="spellStart"/>
        <w:proofErr w:type="gramStart"/>
        <w:p wsp:rsidR="00B75EE1" wsp:rsidRDefault="00B75EE1">
        <w:r wsp:rsidRPr="00B75EE1">
        <w:rPr>
        <w:b/>
        </w:rPr>
        <w:t>Tổng cộng: </w:t>
        </w:r>
        <w:proofErr w:type="spellEnd"/>
        <w:r>
        <w:t>'.number($monney).' VNĐ</w:t>
        </w:r>
        </w:p>';
    }
    
    
    $data .= '</wx:sect>
    </w:body>
    </w:wordDocument>';
    
    $size = strlen($data);
	header("Content-disposition: attachment; filename=HD_".date('d_m_y',gmmktime()).".doc");
	header('Content-type: application/msword; charset=UTF-8');
	header("Content-Length: $size");
	echo $data;
	exit();
}
else echo "Hacking attempt";

?>
