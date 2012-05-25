<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="extensions/extension_installer/utilities/pagination.xsl" />

    <xsl:template match="//extension-list/response">
	
		<style>
			div.paging {
				margin-right: 50px;
				float: right;
			}
			div.paging.bottom {
				margin-top: 10px;
			}
			div.paging a {
				font-size: 12px;
				padding: 10px 5px;
			}
			div.paging a.nolink {
				text-decoration: none;
				color: #000;
			}
		</style>
			
		<h2>Install Extensions - Page <xsl:value-of select="//extension-list/response/extensions/pagination/@current-page"/> of <xsl:value-of select="//extension-list/response/extensions/pagination/@total-pages"/>
		
		<div class="paging">
			<xsl:call-template name="page">
				<xsl:with-param name="pages-to-render" select="extensions/pagination/@total-pages - 1"/>
			</xsl:call-template>
		</div>
		</h2>		
		
		<table class="selectable">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Author</th>
					<th scope="col">Version</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<xsl:for-each select="extensions/extension">
					<tr>
						<td><xsl:value-of select="name"/></td>
						<td><xsl:value-of select="developer/name"/></td>
						<td><xsl:value-of select="version"/></td>
						<xsl:variable name="name" select="name"/>
						<xsl:variable name="dev" select="developer/username"/>
						<xsl:variable name="id" select="@id"/>
						<td>
							<a href="installer/?dev={$dev}&amp;id={$id}&amp;title={$name}">Install</a>
						</td>				
					</tr>
				</xsl:for-each>
				
			</tbody>		
			

		</table>

			
		<div class="paging bottom">
			<xsl:call-template name="page">
				<xsl:with-param name="pages-to-render" select="extensions/pagination/@total-pages - 1"/>
			</xsl:call-template>
		</div>
		
    </xsl:template>
	
	<xsl:template name="page">
		<xsl:param name="pages-to-render"/>

		<xsl:variable name="total-pages" select="//extension-list/response/extensions/pagination/@total-pages"/>
		<xsl:variable name="current-page" select="$total-pages - $pages-to-render"/>

		<xsl:choose>
			<xsl:when test="$current-page = //extension-list/response/extensions/pagination/@current-page">
				<a href="#" class="nolink"><xsl:value-of select="$current-page"/></a>
			</xsl:when>
			<xsl:otherwise>
				<a href="?p={$current-page}"><xsl:value-of select="$current-page"/></a>		
			</xsl:otherwise>
		</xsl:choose>

		
		<xsl:if test="$pages-to-render &gt; 0">
			<xsl:variable name="pages-left" select="$pages-to-render - 1"/>
			<xsl:call-template name="page">
				<xsl:with-param name="pages-to-render" select="$pages-left"/>
			</xsl:call-template>
		</xsl:if>
		
	</xsl:template>	
		
</xsl:stylesheet>