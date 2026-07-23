<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local language pack from https://formations-recette.denkyo.fr
 *
 * @package    block
 * @subpackage recommend_course
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['add_error'] = 'Veuillez sélectionner au moins un utilisateur ou une cohorte et un cours.';
$string['add_success'] = 'Le ou les cours recommandés ont bien été proposés aux utilisateurs sélectionnés.';
$string['all_recommendation'] = 'Historiques de mes recommandations';
$string['availableplaceholders'] = 'Variables disponibles :';
$string['back_dashboard'] = 'Retour au tableau de bord';
$string['blocktitle'] = 'Lumière sur...';
$string['button'] = 'Ajouter un cours';
$string['by'] = 'Suggéré par';
$string['course'] = 'Cours';
$string['course_recommendations_stats'] = 'Statistiques';
$string['default_email_body'] = 'Bonjour,<br><br>Le cours "[course_name]" pourrait vous intéresser.<br>Rendez-vous sur <a href="">Moodle</a> pour en savoir plus !<br><br>A bientôt !<br>__<br>[recommended_by]';
$string['default_email_subject'] = 'Nouveau cours sur Moodle !';
$string['description'] = 'Ce bloc permet de proposer des cours aux utilisateurs.';
$string['details_below'] = 'Plus d\'info ci-dessous';
$string['emailbody'] = 'Contenu du courriel';
$string['emailbody_help'] = 'Personnalisez le message envoyé au destinataire :<br>
• <code>[course_name]</code> : nom du cours recommandé,<br>
• <code>[recommended_by]</code> : nom de la personne ayant recommandé le cours.';
$string['emailsubject'] = 'Objet du courriel';
$string['emailsubject_help'] = 'Renseignez l\'objet du courriel.';
$string['email_open'] = 'Vous avez reçu une nouvelle recommandation de cours.';
$string['email_subject'] = 'On vous recommande un nouveau cours.';
$string['enable'] = 'Activé';
$string['historytitle'] = 'Historique';
$string['history_table_caption'] = 'Historique des recommandations';
$string['leastrecommended'] = 'Cours les moins recommandés';
$string['messageprovider:recommendation_both'] = 'Recommandation (par courriel et par notification)';
$string['messageprovider:recommendation_email'] = 'Recommandation (par courriel uniquement)';
$string['messageprovider:recommendation_popup'] = 'Recommandation (par notification uniquement)';
$string['mostrecommended'] = 'Cours les plus recommandés';
$string['nobottomcourses'] = 'Aucun cours';
$string['nocoursesfound'] = 'Aucun cours';
$string['nopermission'] = 'Vous n\'avez pas les droits suffisants pour accéder à cette page.';
$string['noselection_string'] = 'Rechercher des utilisateurs ou des cohortes';
$string['notopcourses'] = 'Aucun cours';
$string['pluginname'] = 'Recommandation de cours';
$string['pluginname:addinstance'] = 'Ajouter un bloc Recommandation de cours';
$string['pluginname:myaddinstance'] = 'Ajouter un bloc Recommandation de cours';
$string['privacy:metadata'] = 'Ce bloc ne stocke aucune donnée personnelle et fonctionne uniquement à partir des identifiants des utilisateurs.';
$string['privacy:metadata:block_recommend_course_rds'] = 'Stockages des recommandations faites par les utilisateurs';
$string['privacy:metadata:block_recommend_course_rds:course_id'] = 'Identifiant du cours recommandé';
$string['privacy:metadata:block_recommend_course_rds:created_on'] = 'Horodatage de la recommandation';
$string['privacy:metadata:block_recommend_course_rds:receiver_id'] = 'Identifiant utilisateur du destinataire';
$string['privacy:metadata:block_recommend_course_rds:sender_id'] = 'Identifiant de l\'utilisateur à l\'origine de la recommandation';
$string['recommeded_by'] = 'Recommandé par';
$string['recommendation_history'] = 'Afficher l\'historique';
$string['recommendation_message'] = '{$a->user} vous recommande le cours "{$a->course}".';
$string['recommendation_setting'] = 'Paramètres';
$string['recommendation_small'] = 'On vous recommande un nouveau cours.';
$string['recommendation_subject'] = 'Nouveau cours sur Moodle !';
$string['recommendeddate'] = 'Recommandé le';
$string['recommendedto'] = 'Destinataire';
$string['recommended_by'] = 'Recommandé par';
$string['recommended_date'] = 'Date';
$string['recommended_to'] = 'Destinataire';
$string['recommend_course:addinstance'] = 'Ajouter un bloc Recommandation de cours';
$string['recommend_course:myaddinstance'] = 'Ajouter un bloc Recommandation de cours';
$string['recommend_course:settings'] = 'Paramétrages';
$string['recommend_course:viewstats'] = 'Afficher les statistiques';
$string['savesettings'] = 'Enregistrer';
$string['select_cohorts'] = 'Cohortes';
$string['select_course'] = 'Cours';
$string['select_users'] = 'Utilisateurs';
$string['sendemail'] = 'Envoyer un courriel aux utilisateurs sélectionnés';
$string['sendemail_help'] = 'Si les notifications par courriel sont bien activées, un courriel sera envoyé aux utilisateurs sélectionnés pour chaque recommandation.';
$string['sendnotification'] = 'Notifier les utilisateurs sélectionnés';
$string['sendnotification_help'] = 'Si les notifications Web sont bien activées, une notification apparaîtra pour les utilisateurs sélectionnés pour chaque recommandation.';
$string['serialno'] = 'Rang';
$string['show_all'] = 'Montrer toutes les recommandations';
$string['submit'] = 'Envoyer';
$string['title'] = 'Recommander un cours';
$string['totalrecommendations'] = 'Nombre de recommandations';
$string['unknowncourse'] = 'Cours non connu';
$string['view_course'] = 'Afficher le cours';
