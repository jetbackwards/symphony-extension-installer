<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/response">
		<xsl:choose>
			<xsl:when test="success = '1'">
				<h2>Installed Successfully!</h2>
			</xsl:when>
			<xsl:otherwise>
				<h2>Install Failed</h2>
			</xsl:otherwise>
		</xsl:choose>
		
		<p>
			<xsl:value-of select="message"/>
		</p>
		
    </xsl:template>

</xsl:stylesheet>