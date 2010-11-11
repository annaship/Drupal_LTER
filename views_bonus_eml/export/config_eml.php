<?php
/* 
 * Here goes an site specific information
 */

  // TODO: hardcode the pubPlace, specific for every given site
  // example: <pubPLace> Plum Island Ecosystems LTER </pubPlace>
  // for now taking automatically: variable_get('site_name', NULL);

  // package_id is scope.identifier.version
  // for LTER, scope is "knb-lter-ACR" where ACR is the three leter site acronym
  // Non-lTER sites may not have a convention for the scope
  // Identifier is a unique identifier -- usually from the "data set ID".
  // Version is the $ver_id, a composites of Drupal VIDs for the related NIDs.
  $acr='sev'; // Sevilleta acronym
  // $id = content_type_data_set.content_field_dataset_id ;
  $scope='knb-lter-'.$acr;
  $package_id = $acr . '.' .$id.'.'. $ver_vid;



  // put allowed HTML tags here
  function views_bonus_eml_my_strip_tags($content = '') {
    return strip_tags($content, '<p><h1><h2><h3><h4><h5><a><pre><para>');
  }

  //language
  $language = 'english';

  // Intellectual Rights
  $intellectual_rights = '';
  $data_policies = '';
  
  //Access group  -- need for the stupid metacat --
  //
  //<access scope="document" order="allowFirst" authSystem="knb">
  //    <allow>
  //		<principal>uid=ACR,o=lter,dc=ecoinformatics,dc=org</principal>
  //		<permission>all</permission>
  //	</allow>
  //	<allow>
  //		<principal>public</principal>
  //		<permission>read</permission>
  //	</allow>
  //</access>
  //

  $intellectual_rights = 'Any Sevilleta LTER data set and accompanying metadata can be used for academic, research, and other professional purposes. Permission to use the data is granted to the Data User subject to the following terms: Data User will: 1) notify the designated contact (e.g., Principle Investigator or Data Set Contact) when any derivative work based on or derived from the data and documentation is distributed; 2) notify users that such derivative work is a modified version and not the original data and documentation distributed by the Sevilleta LTER; 3) not redistribute original data and documentation; 4) acknowledge the support of the Sevilleta LTER and appropriate NSF Grant numbers in any publications using these data and documentation. (e.g. Data sets were provided by the Sevilleta LTER Data Bank. Funding for these data was provided by the National Science Foundation Long-Term Ecological Research program (NSF Grant numbers BSR 88-11906, DEB9411976, DEB0080529, DEB0217774); and 5) send two reprints of any publications resulting from use of the data and documentation to the following address: Sevilleta LTER Program Attn: Information Manager, Department of Biology, MSC03 2020, University of New Mexico, Albuquerque, NM 87131';

  $data_policies = 'Sevilleta Data Use Agreement.  Definitions
    Data Set: Digital data and its metadata derived from any research activity such as field observations, collections, laboratory analysis, experiments, or the post-processing of existing data and identified by a unique identifier issued by a recognized cataloging authority such as a site, university, agency, or other organization.
    Data User: Individual to whom access has been granted to this Data Set, including his or her immediate collaboration sphere, defined here as the institutions, partners, students and staff with whom the Data User collaborates, and with whom access must be granted, in order to fulfill the Data User\'s intended use of the Data Set
    Data Set Creator: Individual or institution that produced the Data Set
    Data Set Owner: Individual or institution that holds intellectual property rights to the dataset. Note that this may or may not be defined as a legal copyright. If no other party is designated in the metadata as Data Set Owner, it may be presumed that these rights are held by the Data Set Creator.
    Data Set Distributor: Individual or institution providing access to the Data Sets.
    Data Set Contact: Party designated in the accompanying metadata of the Data Set as the primary contact for the Data Set.

Conditions of Use

The re-use of scientific data has the potential to greatly increase communication, collaboration and synthesis within and among disciplines, and thus is fostered, supported and encouraged. Permission to use this dataset is granted to the Data User free of charge subject to the following terms:

    1) Acceptable use. Use of the dataset will be restricted to academic, research, educational, government, recreational, or other not-for-profit professional purposes. The Data User is permitted to produce and distribute derived works from this dataset provided that they are released under the same license terms as those accompanying this Data Set. Any other uses for the Data Set or its derived products will require explicit permission from the dataset owner.
    2 ) Redistribution. The data are provided for use by the Data User. The metadata and this license must accompany all copies made and be available to all users of this Data Set. The Data User will not redistribute the original Data Set beyond this collaboration sphere.
    3 ) Citation. It is considered a matter of professional ethics to acknowledge the work of other scientists. Thus, the Data User will properly cite the Data Set in any publications or in the metadata of any derived data products that were produced using the Data Set. Citation should take the following general form: Creator, Year of Data Publication, Title of Dataset, Publisher, Dataset identifier. For example:

        Muldavin, E. 2004. Sevilleta LTER Fertilizer NPP Study Dataset. Albuquerque, NM: Sevilleta Long Term Ecological Research Site Database: SEV155. http://sev.lternet.edu/project_details.php?id=SEV155. (28 July 2005)

    4 ) Acknowledgement. The Data User should acknowledge any institutional support or specific funding awards referenced in the metadata accompanying this dataset in any publications where the Data Set contributed significantly to its content. Acknowledgements should identify the supporting party, the party that received the support, and any identifying information such as grant numbers. For example:

        Data sets were provided by the Sevilleta Long Term Ecological Research (LTER) Program. Significant funding for collection of these data was provided by the National Science Foundation Long Term Ecological Research program (NSF Grant numbers BSR 88-11906, DEB 9411976, DEB 0080529 and DEB 0217774).

    5 ) Notification. The Data User will notify the Data Set Contact when any derivative work or publication based on or derived from the Data Set is distributed. The Data User will provide the data contact with two reprints of any publications resulting from use of the Data Set and will provide copies, or on-line access to, any derived digital products. Notification will include an explanation of how the Data Set was used to produce the derived work.

    Reprints should be sent to:

    Sevilleta LTER Information Manager
    Department of Biology
    Castetter Hall Rm. 167
    University of New Mexico
    Albuquerque, NM 87131

    6 ) Collaboration. The Data Set has been released in the spirit of open scientific collaboration. Data Users are thus strongly encouraged to consider consultation, collaboration and/or co-authorship with the Data Set Creator.

By accepting this Data Set, the Data User agrees to abide by the terms of this agreement. The Data Owner shall have the right to terminate this agreement immediately by written notice upon the Data User\'s breach of, or non-compliance with, any of its terms. The Data User may be held responsible for any misuse that is caused or encouraged by the Data User\'s failure to abide by the terms of this agreement.

Disclaimer

While substantial efforts are made to ensure the accuracy of data and documentation contained in this Data Set, complete accuracy of data and metadata cannot be guaranteed. All data and metadata are made available "as is". The Data User holds all parties involved in the production or distribution of the Data Set harmless for damages resulting from its use or interpretation.

Data Availability

The Sevilleta LTER\'s goal is to make most data available via the WWW no later than two years following collection and no later than the publication of the main findings from the dataset. This policy conforms to the LTER Network standards. However, it not possible for all data to be made available on these terms for various reasons. We therefore recognize two types of data sets:

Type 1 data are freely available upon user acceptance of the terms listed in the Data Use Agreement.

Type 2 data are not freely available and these data are to be released to restricted audiences according to terms specified by the owners of the data. Metadata for Type 2 data will generally be made freely available via the Internet. Type 2 status will be assigned to electronic data that meet one or more of the conditions listed below. These data are restricted access based on specific justifications provided by the Principle Investigator.

Conditions Justifying Type 2 Status:

   1. Data contains sensitive information about, for instance, human subjects, location of archeological ruins or artifacts, or locations of threatened or endangered species.
   2. Data are covered by copyright laws (e.g., ADAR satellite imagery)
   3. The quality of the data is questionable, because QA/QC has not yet been done orthe dataset is a legacy dataset for which little documentation is available. Requests for legacy datasets should be accompanied by a proposal for improving the quality of these data sets.
   4. The data was collected by a graduate student, post-doc, or other individual whose professional development might be compromised if their data were used by others before they have had the opportunity to publish on it first.
';

  // TODO: create metadataProvider and publisher as a regular nodes
  // via dataset CCT form / eml2drupal script

  // metadataProvider
$metadata_provider_obj = (object) array(
  'nid'                       => 'fake_nid',
  'field_person_first_name'   => array ( array ('value' => '')),
  'field_person_last_name'    => array ( array ('value' => '')),
  'field_person_organization' => array ( array ('value' => 'Sevilleta LTER')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_city'         => array ( array ('value' => 'Albuquerque')),
  'field_person_state'        => array ( array ('value' => 'new Mexico')),
  'field_person_zipcode'      => array ( array ('value' => '87131')),
  'field_person_country'      => array ( array ('value' => 'USA')),
  'field_person_phone'        => array ( array ('value' => '')),
  'field_person_fax'          => array ( array ('value' => '')),
  'field_person_role'         => array ( array ('value' => 'metadataProvider')),
  'field_person_email' 	      => array ( array ('value' => 'data-use@sevilleta.unm.edu')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_personid'     => array ( array ('value' => '')),
);


  // publisher
$publisher_obj = (object) array(
  'nid'                       => 'fake_nid',
  'field_person_first_name'   => array ( array ('value' => '')),
  'field_person_last_name'    => array ( array ('value' => '')),
  'field_person_organization' => array ( array ('value' => 'Sevilleta LTER')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_city'         => array ( array ('value' => 'Albuquerque')),
  'field_person_state'        => array ( array ('value' => 'new Mexico')),
  'field_person_zipcode'      => array ( array ('value' => '87131')),
  'field_person_country'      => array ( array ('value' => 'USA')),
  'field_person_phone'        => array ( array ('value' => '')),
  'field_person_fax'          => array ( array ('value' => '')),
  'field_person_role'         => array ( array ('value' => 'metadataProvider')),
  'field_person_email' 	      => array ( array ('value' => 'data-use@sevilleta.unm.edu')),
  'field_person_address'      => array ( array ('value' => 'Department of Biology, University of New Mexico, MSC30 2020 ')),
  'field_person_personid'     => array ( array ('value' => '')),
);


$metadata_provider_arr = array ($metadata_provider_obj);
$publisher_arr         = array ($publisher_obj);

?>
