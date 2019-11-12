<?php

/*
 * This file is part of RaspiSMS.
 *
 * (c) Pierre-Lin Bonnemaison <plebwebsas@gmail.com>
 *
 * This source file is subject to the GPL-3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace controllers\internals;

    /**
     * Classe des sendedes.
     */
    class Sended extends \descartes\InternalController
    {
        private $model_sended;

        public function __construct(\PDO $bdd)
        {
            $this->model_sended = new \models\Sended($bdd);
        }

        /**
         * List sms for a user
         * @param int $id_user : user id
         * @param mixed(int|bool) $nb_entry : Number of entry to return
         * @param mixed(int|bool) $page     : Pagination, will offset $nb_entry * $page results
         * @return array
         */
        public function list($id_user, $nb_entry = null, $page = null)
        {
            return $this->model_sended->list_for_user($id_user, $nb_entry, $nb_entry * $page);
        }
        
        /**
         * Return a sended sms
         * @param $id : received id
         * @return array
         */
        public function get($id)
        {
            return $this->model_sended->get($id);
        }

        /**
         * Cette fonction retourne une liste des sendedes sous forme d'un tableau.
         *
         * @param array int $ids : Les ids des entrées à retourner
         *
         * @return array : La liste des sendedes
         */
        public function gets($ids)
        {
            //Recupération des sendedes
            return $this->model_sended->gets($ids);
        }

        /**
         * Cette fonction retourne les X dernières entrées triées par date.
         *
         * @param mixed false|int $nb_entry : Nombre d'entrée à retourner ou faux pour tout
         *
         * @return array : Les dernières entrées
         */
        public function get_lasts_by_date($nb_entry = false)
        {
            return $this->model_sended->get_lasts_by_date($nb_entry);
        }

        /**
         * Cette fonction retourne une liste des receivedes sous forme d'un tableau.
         *
         * @param string $destination : Le numéro auquel est envoyé le message
         *
         * @return array : La liste des sendeds
         */
        public function get_by_destination($destination)
        {
            //Recupération des sendeds
            return $this->model_sended->get_by_destination($destination);
        }

        /**
         * Cette fonction va supprimer une liste de sendeds.
         *
         * @param array $ids : Les id des sendedes à supprimer
         * @param mixed $id
         *
         * @return int : Le nombre de sendedes supprimées;
         */
        public function delete($id)
        {
            return $this->model_sended->delete($id);
        }

        /**
         * Cette fonction insert une nouvelle sendede.
         *
         * @param array $sended : Un tableau représentant la sendede à insérer
         *
         * @return mixed bool|int : false si echec, sinon l'id de la nouvelle sendede insérée
         */
        public function create($sended)
        {
            return $this->model_sended->create($sended);
        }

        /**
         * Cette fonction permet de compter le nombre de sendeds.
         *
         * @return int : Le nombre d'entrées dans la table
         */
        public function count()
        {
            return $this->model_sended->count();
        }

        /**
         * Cette fonction compte le nombre de sendeds par jour depuis une date.
         *
         * @param mixed $date
         *
         * @return array : un tableau avec en clef la date et en valeure le nombre de sms envoyés
         */
        public function count_by_day_since($date)
        {
            $counts_by_day = $this->model_sended->count_by_day_since($date);
            $return = [];

            foreach ($counts_by_day as $count_by_day)
            {
                $return[$count_by_day['at_ymd']] = $count_by_day['nb'];
            }

            return $return;
        }

        /**
         * Decrement before delivered.
         *
         * @param int $id_sended : id of the sended to decrement delivered for
         *
         * @return array
         */
        public function decrement_before_delivered($id_sended)
        {
            return $this->model_sended->decrement_before_delivered($id_sended);
        }

        /**
         * Update status.
         *
         * @param int    $id_sended : id of the sended to mark as delivered
         * @param string $status    : new status
         *
         * @return int
         */
        public function update_status($id_sended, $status)
        {
            return $this->model_sended->update($id_sended, ['status' => $status]);
        }

        /**
         * Update sended to delivered.
         *
         * @param int $id_sended : id of the sended to mark as delivered
         *
         * @return int
         */
        public function set_delivered($id_sended)
        {
            return $this->model_sended->update($id_sended, ['status' => 'delivered']);
        }
    }
