<?php
/*
 * Copyright (C) 2006 - 2014 FOSS-Group
 *                    Germany
 *                    http://www.foss-group.de
 *                    support@foss-group.de
 *
 * Authors:
 *  Christian Wittkowski <wittkowski@devroom.de>
 *
 * Licensed under the EUPL, Version 1.1 or – as soon they
 * will be approved by the European Commission - subsequent
 * versions of the EUPL (the "Licence");
 * You may not use this work except in compliance with the
 * Licence.
 * You may obtain a copy of the Licence at:
 *
 * https://joinup.ec.europa.eu/software/page/eupl
 *
 * Unless required by applicable law or agreed to in
 * writing, software distributed under the Licence is
 * distributed on an "AS IS" basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied.
 * See the Licence for the specific language governing
 * permissions and limitations under the Licence.
 *
 *
 */

/**
 * LdapStoragePoolDefinition class file.
 *
 * @author: Christian Wittkowski <wittkowski@devroom.de>
 * @version: 1.0
 */

class LdapStoragePoolDefinition extends CLdapRecord {
	protected $_branchDn = 'ou=storage pools,ou=configuration,ou=virtualization,ou=services';
	protected $_filter = array('all' => 'ou=*');
	protected $_dnAttributes = array('ou');
	protected $_objectClasses = array('sstStoragePoolConfigurationObjectClass', 'organizationalUnit', 'top');

	public static function getUriByType($type) {
		$retval = null;
		$def = CLdapRecord::model('LdapStoragePoolDefinition')->findByAttributes(array('attr'=>array('ou'=>$type)));
		if (!is_null($def)) {
			$retval = $def->sstStoragePoolURI;
		}
		return $retval;
	}

	public static function getPathByType($type) {
		$retval = LdapStoragePoolDefinition::getUriByType($type);
		if (!is_null($retval)) {
			$pos = strpos($retval, 'file://');
			if (false !== $pos && 0 == $pos) {
				$retval = substr($retval, 7);
			}
		}
		return $retval;
	}
}