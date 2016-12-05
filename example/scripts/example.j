/*
*    Delimited comment
*/

/**
*    Document comment
*/

library Example

    private keyword Data

    private function OnMapStart takes nothing returns nothing
        local Data structInstance       = Data.create()
        local string test               = "some string"
        local integer invalidRawCode    = 'ab'
        local integer valudRawCode      = 'a'   

        // you can highlight text with : or `
        set :string: `test` = "new value"

        if (GetPlayerName(Player(0)) == "TriggerHappy") then
            call CreateUnit(Player(0), 'hfoo', 0, 0, 270)
        endif

        call structInstance.destroy()
        call DestroyTimer(bj_gameStartedTimer)

        set bj_gameStarted = true
    endfunction

    struct Data

        private static method onInit takes nothing returns nothing
            set bj_gameStartedTimer = CreateTimer()
            call TimerStart(bj_gameStartedTimer, 0., 0., function OnMapStart)
        endmethod

    endstruct

endlibrary