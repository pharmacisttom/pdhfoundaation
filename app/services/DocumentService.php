<?php
namespace App\Services;

use App\Core\Database;
use PDO;

class DocumentService
{
    /**
     * Generate the next running number for a given prefix (e.g., 'DON-', 'RC-')
     * Format: {PREFIX}{BE_YEAR}-{6_DIGIT_NUMBER} (e.g. DON-2569-000001)
     */
    public static function generateNumber($prefix)
    {
        $db = Database::getInstance()->getConnection();
        
        // Calculate current Buddhist Era (พ.ศ.) year
        // We use date('Y') + 543
        $currentYearBE = date('Y') + 543;
        
        try {
            $db->beginTransaction();
            
            // Lock the row for update to prevent race conditions
            $stmt = $db->prepare("SELECT * FROM running_numbers WHERE prefix = :prefix FOR UPDATE");
            $stmt->execute(['prefix' => $prefix]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($record) {
                // If year changed, reset current_number to 1
                if ($record['year'] != $currentYearBE) {
                    $nextNumber = 1;
                } else {
                    $nextNumber = $record['current_number'] + 1;
                }
                
                $updateStmt = $db->prepare("UPDATE running_numbers SET current_number = :num, year = :year WHERE id = :id");
                $updateStmt->execute([
                    'num' => $nextNumber,
                    'year' => $currentYearBE,
                    'id' => $record['id']
                ]);
            } else {
                // First time creating this prefix
                $nextNumber = 1;
                $insertStmt = $db->prepare("INSERT INTO running_numbers (prefix, current_number, year) VALUES (:prefix, :num, :year)");
                $insertStmt->execute([
                    'prefix' => $prefix,
                    'num' => $nextNumber,
                    'year' => $currentYearBE
                ]);
            }
            
            $db->commit();
            
            // Format: DON-2569-000001
            // Pad the number with zeros to make it 6 digits long
            $paddedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            return $prefix . $currentYearBE . '-' . $paddedNumber;
            
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
