<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Chat implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $status;
  public $user_id;
  public $pesan;

  public function __construct($user_id, $pesan)
  {
      $this->user_id = $user_id;
      $this->status = "ok";
      $this->pesan = $pesan;
  }

  public function broadcastOn()
  {
      return ['channel-pesanan'];
  }

  public function broadcastAs()
  {
      return 'event-pesanan';
  }
}