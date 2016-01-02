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

if (check_log() & check_level() >= 3) {
    $total = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products"));
    $data = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Admin</Author>
  <LastAuthor>Admin</LastAuthor>
  <Created>2010-08-12T12:09:16Z</Created>
  <Company>- ETH0 -</Company>
  <Version>11.9999</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>9720</WindowHeight>
  <WindowWidth>15195</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>45</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s22">
   <Alignment ss:Horizontal="Center" ss:Vertical="Top"/>
   <Font x:Family="Swiss" ss:Size="12" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s30">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font x:Family="Swiss" ss:Italic="1"/>
  </Style>
  <Style ss:ID="s31">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font x:Family="Swiss" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s32">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s33">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s34">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="s35">
   <Alignment ss:Horizontal="Center" ss:Vertical="Top"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font x:Family="Swiss" ss:Bold="1" ss:Italic="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
  <Table ss:ExpandedColumnCount="6" ss:ExpandedRowCount="'.($total + 3).'" x:FullColumns="1"
   x:FullRows="1">
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:AutoFitWidth="0" ss:Width="200"/>
   <Column ss:AutoFitWidth="0" ss:Width="150"/>
   <Column ss:AutoFitWidth="0" ss:Width="95" ss:Span="1"/>
   <Column ss:Index="6" ss:AutoFitWidth="0" ss:Width="50"/>
   <Row ss:Height="16">
    <Cell ss:MergeAcross="5" ss:StyleID="s22"><Data ss:Type="String">'.get_option('name').'</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="28">
    <Cell ss:MergeAcross="5" ss:StyleID="s35"><Data ss:Type="String">Bakup thông tin sản phẩm từ Website: '.get_option('url').' ('.date('d/m/Y',gmmktime()).')</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15">
    <Cell ss:StyleID="s30"><Data ss:Type="String">STT</Data></Cell>
    <Cell ss:StyleID="s31"><Data ss:Type="String">TÊN SẢN PHẨM</Data></Cell>
    <Cell ss:StyleID="s31"><Data ss:Type="String">MÃ SẢN PHẨM</Data></Cell>
    <Cell ss:StyleID="s31"><Data ss:Type="String">ĐƠN GIÁ (VNĐ)</Data></Cell>
    <Cell ss:StyleID="s31"><Data ss:Type="String">KHUYẾN MÃI (VNĐ)</Data></Cell>
    <Cell ss:StyleID="s31"><Data ss:Type="String">TỒN KHO</Data></Cell>
   </Row>
    ';
   
   $product = @mysql_query("SELECT product_name, product_code, product_price, product_free, product_total FROM cnt_products ORDER by product_cat");
   while ($pd = @mysql_fetch_array ($product)){
        $i ++;
        $data .= '   <Row>
    <Cell ss:StyleID="s30"><Data ss:Type="Number">'.$i.'</Data></Cell>
    <Cell ss:StyleID="s32"><Data ss:Type="String">'.$pd['product_name'].'</Data></Cell>
    <Cell ss:StyleID="s32"><Data ss:Type="String">'.$pd['product_code'].'</Data></Cell>
    <Cell ss:StyleID="s34"><Data ss:Type="Number">'.$pd['product_price'].'</Data></Cell>'."\r\n";
    if($pd['product_free'] != 0) $data .= '    <Cell ss:StyleID="s34"><Data ss:Type="Number">'.$pd['product_free'].'</Data></Cell>'."\r\n";
    else $data .= '    <Cell ss:StyleID="s33"><Data ss:Type="String">Không</Data></Cell>'."\r\n";
    $data .= '    <Cell ss:StyleID="s34"><Data ss:Type="Number">'.$pd['product_total'].'</Data></Cell>
   </Row>'."\r\n";
   }
    $data .= '</Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>200</HorizontalResolution>
    <VerticalResolution>200</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>2</ActiveRow>
     <ActiveCol>1</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet2">
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet3">
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>';
    $size = strlen($data);
	header("Content-disposition: attachment; filename=SP_".date('d_m_y',gmmktime()).".xls");
	header('Content-type: application/excel; charset=UTF-8');
	header("Content-Length: $size");
	echo $data;
	exit();
}
else echo "Hacking attempt";

?>
