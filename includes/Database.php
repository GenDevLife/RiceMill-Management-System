<?php
/**
 * Database Helper Class
 * Rice Mill Management System
 * 
 * ใช้ prepared statements เพื่อป้องกัน SQL Injection
 */

require_once __DIR__ . '/config.php';

class Database {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getConnection();
    }
    
    /**
     * Get PDO connection
     */
    public function getConnection() {
        return $this->pdo;
    }
    
    // ==================== Generic Methods ====================
    
    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Fetch one row
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    /**
     * Execute query (INSERT, UPDATE, DELETE)
     */
    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    // ==================== Member Methods ====================
    
    /**
     * Get all members
     */
    public function getMembers($limit = 100, $offset = 0) {
        return $this->fetchAll(
            "SELECT * FROM members ORDER BY id DESC LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }
    
    /**
     * Get member by ID
     */
    public function getMember($id) {
        return $this->fetchOne(
            "SELECT * FROM members WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Search members by name or phone
     */
    public function searchMembers($keyword) {
        $keyword = '%' . $keyword . '%';
        return $this->fetchAll(
            "SELECT * FROM members WHERE name LIKE ? OR phone LIKE ? ORDER BY name LIMIT 50",
            [$keyword, $keyword]
        );
    }
    
    /**
     * Register new member
     */
    public function registerMember($name, $phone, $address, $subdistrict, $district, $province = 'พิจิตร') {
        $this->execute(
            "INSERT INTO members (name, phone, points, address, subdistrict, district, province, created_at) 
             VALUES (?, ?, 0, ?, ?, ?, ?, date('now'))",
            [$name, $phone, $address, $subdistrict, $district, $province]
        );
        return $this->lastInsertId();
    }
    
    /**
     * Update member points
     */
    public function updateMemberPoints($memberId, $points) {
        return $this->execute(
            "UPDATE members SET points = ? WHERE id = ?",
            [$points, $memberId]
        );
    }
    
    /**
     * Add points to member
     */
    public function addMemberPoints($memberId, $pointsToAdd) {
        return $this->execute(
            "UPDATE members SET points = points + ? WHERE id = ?",
            [$pointsToAdd, $memberId]
        );
    }
    
    /**
     * Deduct points from member
     */
    public function deductMemberPoints($memberId, $pointsToDeduct) {
        return $this->execute(
            "UPDATE members SET points = points - ? WHERE id = ?",
            [$pointsToDeduct, $memberId]
        );
    }
    
    /**
     * Get members ordered by points
     */
    public function getMembersByPoints($limit = 50) {
        return $this->fetchAll(
            "SELECT * FROM members ORDER BY points DESC LIMIT ?",
            [$limit]
        );
    }
    
    /**
     * Count total members
     */
    public function countMembers() {
        $result = $this->fetchOne("SELECT COUNT(*) as count FROM members");
        return $result['count'];
    }
    
    // ==================== Order Product Methods ====================
    
    /**
     * Insert product order
     */
    public function insertOrderProduct($memberId, $riceBranKg, $huskKg, $riceChunksKg, $brokenRiceKg, $totalPrice) {
        $this->execute(
            "INSERT INTO order_products (member_id, order_date, rice_bran_kg, husk_kg, rice_chunks_kg, broken_rice_kg, total_price) 
             VALUES (?, date('now'), ?, ?, ?, ?, ?)",
            [$memberId, $riceBranKg, $huskKg, $riceChunksKg, $brokenRiceKg, $totalPrice]
        );
        return $this->lastInsertId();
    }
    
    /**
     * Get product orders by member
     */
    public function getProductOrdersByMember($memberId) {
        return $this->fetchAll(
            "SELECT * FROM order_products WHERE member_id = ? ORDER BY order_date DESC",
            [$memberId]
        );
    }
    
    /**
     * Get last product order by member
     */
    public function getLastProductOrder($memberId) {
        return $this->fetchOne(
            "SELECT * FROM order_products WHERE member_id = ? ORDER BY id DESC LIMIT 1",
            [$memberId]
        );
    }
    
    // ==================== Order Service Methods ====================
    
    /**
     * Insert service order
     */
    public function insertOrderService($memberId, $serviceType, $weightKg, $totalPrice) {
        $this->execute(
            "INSERT INTO order_services (member_id, order_date, service_type, weight_kg, total_price) 
             VALUES (?, date('now'), ?, ?, ?)",
            [$memberId, $serviceType, $weightKg, $totalPrice]
        );
        return $this->lastInsertId();
    }
    
    /**
     * Get service orders by member
     */
    public function getServiceOrdersByMember($memberId) {
        return $this->fetchAll(
            "SELECT * FROM order_services WHERE member_id = ? ORDER BY order_date DESC",
            [$memberId]
        );
    }
    
    /**
     * Get last service order by member
     */
    public function getLastServiceOrder($memberId) {
        return $this->fetchOne(
            "SELECT * FROM order_services WHERE member_id = ? ORDER BY id DESC LIMIT 1",
            [$memberId]
        );
    }
    
    // ==================== Promotion Methods ====================
    
    /**
     * Insert promotion redemption
     */
    public function insertPromotion($memberId, $promotionType, $pointsUsed) {
        $this->execute(
            "INSERT INTO promotions (member_id, redeem_date, promotion_type, points_used) 
             VALUES (?, date('now'), ?, ?)",
            [$memberId, $promotionType, $pointsUsed]
        );
        return $this->lastInsertId();
    }
    
    /**
     * Get promotions by member
     */
    public function getPromotionsByMember($memberId) {
        return $this->fetchAll(
            "SELECT * FROM promotions WHERE member_id = ? ORDER BY redeem_date DESC",
            [$memberId]
        );
    }
    
    /**
     * Get last promotion by member
     */
    public function getLastPromotion($memberId) {
        return $this->fetchOne(
            "SELECT * FROM promotions WHERE member_id = ? ORDER BY id DESC LIMIT 1",
            [$memberId]
        );
    }
    
    // ==================== Statistics Methods ====================
    
    /**
     * Get total sales today
     */
    public function getTodaySales() {
        $products = $this->fetchOne(
            "SELECT COALESCE(SUM(total_price), 0) as total FROM order_products WHERE order_date = date('now')"
        );
        $services = $this->fetchOne(
            "SELECT COALESCE(SUM(total_price), 0) as total FROM order_services WHERE order_date = date('now')"
        );
        
        return ($products['total'] ?? 0) + ($services['total'] ?? 0);
    }
    
    /**
     * Get total orders today
     */
    public function getTodayOrderCount() {
        $products = $this->fetchOne(
            "SELECT COUNT(*) as count FROM order_products WHERE order_date = date('now')"
        );
        $services = $this->fetchOne(
            "SELECT COUNT(*) as count FROM order_services WHERE order_date = date('now')"
        );
        
        return ($products['count'] ?? 0) + ($services['count'] ?? 0);
    }
    
    /**
     * Get monthly sales
     */
    public function getMonthlySales($year, $month) {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = sprintf('%04d-%02d-31', $year, $month);
        
        $products = $this->fetchOne(
            "SELECT COALESCE(SUM(total_price), 0) as total FROM order_products 
             WHERE order_date BETWEEN ? AND ?",
            [$startDate, $endDate]
        );
        $services = $this->fetchOne(
            "SELECT COALESCE(SUM(total_price), 0) as total FROM order_services 
             WHERE order_date BETWEEN ? AND ?",
            [$startDate, $endDate]
        );
        
        return ($products['total'] ?? 0) + ($services['total'] ?? 0);
    }
}
