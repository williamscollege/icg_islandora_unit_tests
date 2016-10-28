<?php
	require_once('Site_Common_Battery_Test.php');

	class Site_Main_Test extends MultiSiteIslandoraWebTestCase {

		function Site_Main_Test() {
			# Set site name
			$this->setMultiSite('');
			echo "<p></p><hr><h3>TESTING: " . $this->getTestingUrlBase() . "</h3>";
		}

		#############################################################
		# Test Basics and Specific Pages
		#############################################################

		function TestSiteBasics() {
			$this->doStandardBasicSiteTests();
		}

		function TestStartAProject() {
			$this->get(FULL_APP_URL . '/start-a-project');
			$this->standardResponseChecks();
		}

		function TestProjectLeads() {
			$this->fail("IMPROVEMENT IDEA: Change path 'project-leads' to 'discover-collections'?"); // also change TestDiscoverCollections
			$this->get(FULL_APP_URL . '/project-leads');
			$this->standardResponseChecks();
		}

		function TestFAQ() {
			$this->fail("IMPROVEMENT IDEA: Change path '/node/6' to '/faq'?");
			$this->get(FULL_APP_URL . '/node/6');
			$this->standardResponseChecks();
		}

		#############################################################
		# Test Solution Packs
		#############################################################

		function Test_SolutionPacks_Begin() {
			echo "<p><strong>Testing Solution Packs</strong></p>";
			echo "<ul>";
		}

		function TestContentModelDisplay_Audio() {
			$this->doContentModelTest_Audio('', 'andyjaffe', '49');
		}

		function TestContentModelDisplay_BasicImage() {
			$this->doContentModelTest_BasicImage('', 'alexanderdavidson', '205');
		}

		function TestContentModelDisplay_Binary() {
			$this->doContentModelTest_Binary('', '', '');
		}

		function TestContentModelDisplay_Book() {
			$this->doContentModelTest_Book('', '', '');
		}

		function TestContentModelDisplay_Compound() {
			$this->doContentModelTest_Compound('', '', '');
		}

		function TestContentModelDisplay_LargeImage() {
			$this->doContentModelTest_LargeImage('', 'hopkinsforestmaps', '186');
		}

		function TestContentModelDisplay_PDF() {
			$this->doContentModelTest_PDF('', 'facultyarticles', '135');
		}

		function TestContentModelDisplay_Video() {
			$this->doContentModelTest_Video('', 'andyjaffe', '42');
		}

		function Test_SolutionPacks_End() {
			echo "</ul>";
		}

		#############################################################
		# Test Collections and Objects (this site only)
		#############################################################

		function TestAccessibility_Collection_And_Object() {
			# array elements: ['collection_id', 'object_id']
			$array_collection_and_object_ids = [
				['alexanderdavidson%3Aphotography', 'alexanderdavidson%3A237']
				, ['andyjaffe%3Aproject', 'andyjaffe%3A49']
				, ['architectural-plans%3Aimages', 'architectural-plans%3A7']
				, ['archivesartifactcollection%3Aimages', 'archivesartifactcollection%3A3']
				, ['archivesmovingimages%3Avideos', 'archivesmovingimages%3A1']
				, ['archivespapermaterials%3Aimages', 'archivespapermaterials%3A57']
				, ['archivesphotocollection%3Aimages', 'archivesphotocollection%3A587']
				, ['costumearchives%3Aimages', 'costumearchives%3A28']
				, ['daviscenter%3Avideos', 'daviscenter%3A67']
				, ['daviscenter%3Aposters', 'daviscenter%3A30']
				, ['davislectureseriesimages%3Aimages', '']
				, ['dively%3Aposters', 'dively%3Aposters']
				, ['dwight%3Apapers', 'dwight%3A32']
				, ['ephraim%3Apipetongs', '']
				, ['ephraimwilliamsproject%3Aimages', 'ephraimwilliamsproject%3A11']
				, ['facultyarticles%3Atext', 'facultyarticles%3A133']
				, ['foundingdocuments%3Aimages', 'foundingdocuments%3A1']
				, ['holley%3Apapers', 'holley%3A17']
				, ['hopkinsforestmaps%3Aimages', 'hopkinsforestmaps%3A241']
				, ['islandora%3Aicgdemo', '']
				, ['lavaka%3Aimages', 'lavaka%3A64']
				, ['maps%3Awilliamstown', 'maps%3A14']
				, ['oralhistoryproject%3Aabstracts', 'oralhistoryproject%3A1']
				, ['presidentialinduction%3Aspeeches', 'presidentialinduction%3A7']
				, ['psalmodiarchaeology%3Aimages', 'psalmodiarchaeology%3A177']
				, ['reily%3Ascrapbook', 'reily%3A50']
				, ['sedimentology%3Aimages', 'sedimentology%3A319']
				, ['shakers%3Ahighlights', 'shakers%3A63']
				, ['shakers%3Asongbooks', 'shakers%3A35']
				, ['studenttheses%3Aobject', 'studenttheses%3A242']
				, ['williams-higher-education%3Amixed-materials', 'williams-higher-education%3A27']
				// , ['','']
			];

			$this->doTestSite_Collections_and_Objects($array_collection_and_object_ids);
		}

		#############################################################
		# Test Search and Facets
		#############################################################

		function TestSearch_Type() {
			$this->get(FULL_APP_URL . '/islandora/search?f[0]=dc.type%3A%22Physical%5C%20Object%22');
			$this->standardResponseChecks();
		}

		function TestSearch_Facets() {
			$this->get(FULL_APP_URL . '/islandora/search/z?type=dismax'); // hack to return smaller resultset to avoid timeout
			//$this->get(FULL_APP_URL . '/islandora/search/'); // this causes timeout: too much data for simpletest to parse
			//$this->get(FULL_APP_URL . '/islandora/search?f[0]=dc.type%3A%22Physical%5C%20Object%22'); // hack to return smaller resultset to avoid timeout
			//$this->get(FULL_APP_URL . '/islandora/search/%20?islandora_solr_search_navigation=0'); // hack to return smaller resultset to avoid timeout
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Collection<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Name<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Department or Group<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Type<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Subject<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Geographic<\\/h3>/i');
			$this->assertPattern('/<div class="islandora-solr-facet-wrapper"><h3>Language<\\/h3>/i');
		}

		#############################################################
		# Utility Tool: Flush content to keep browser alive
		#############################################################
		function Test_Utility_KeepBrowserAlive() {
			$this->util_KeepBrowserAlive_Flush(); // prevent browser timeout issues
		}

	}