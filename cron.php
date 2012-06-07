<?php
/**
 * This is a cron task. Run at, say an hourly basis. Automatically loads cron tasks
 */
require_once('emulator/include.php');

echo "Creating random transactions...\n";

// We'll loop through three times, with a 75%, 50% and 25% chance that a particular
// active card will make a transaction
for($i = 1; $i < 4; $i++ ) {
  foreach(Card::all(array('conditions' => 'status = ' . Card:: $STATUS_ACTIVE)) as $card) {
    $rand = rand(0, 100);
    // 75/50/25% chance this account will make a transaction
    if($rand > (25 * $i))
      createRandomTransaction($card);
  }
}

echo "Completed making random transactions!\n";

/**
 * Creates a random transaction for a card
 */
function createRandomTransaction(Card $card) {
  $balance = $card->balance();
  if($balance < 5) return; // do nothing if balance is less than $5
  
  // Get the transfer amount. It will always be between $3 and min(account_balance, $500)
  $tnxAmount = -1 * rand(300, (int) (min($balance, 500) * 100.0)) / 100.0;
  
  try {
    // 90% chance it's a purchase!
    if(rand(0,100) < 90) {
      echo "Creating random purchase of $$tnxAmount for card #{$card->id}\n";
      $card->createTransaction('purchase', $tnxAmount, 'General purchase', getRandomMerchant());
    } else {
      echo "Making an ATM withdrawl of $$tnxAmount and an ATM fee of $2 for card #{$card->id}\n";
      $card->createTransaction('atm', $tnxAmount, 'ATM Withdrawl');
      $card->createTransaction('atm_fee', -2.00, 'ATM Withdrawl Fee');
    }
  } catch (Exception $e) {
    echo "Exception when making transaction: " . $e->getMessage() . "\n";
    echo $e;
  }
}

function getRandomMerchant() {
  $merchants = array(
    'Alpha Alpine',
    'Bravo Bowling',
    'Charlie Coins',
    'Delta Dancing',
    'Echo Roofing',
    'Fairway Golfing'
  );
  return $merchants[array_rand($merchants)];
}